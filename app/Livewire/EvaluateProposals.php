<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Notification;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;


class EvaluateProposals extends Component
{
    public $postId;
    public $post;
    public $showDssModal = false;
    public $dssResults = [];
    public $recommendedAgency = null;
    public $dssExplanation;
    public $selectedAgencyIds = [];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->loadPost(); // Always fresh data
    }

    /** Load ONLY negotiating responses - called on mount & updates */
    public function loadPost()
    {
        $this->post = Post::with(['responses' => function ($query) {
            $query->whereIn('status', ['accepted', 'negotiating', 'not_selected'])
                ->with(['agency.profile', 'proposedRates.guardType']);
        }])->findOrFail($this->postId);
    }


    public function openDssModal()
    {
        $responses = $this->post->responses()
            ->with(['agency.profile', 'proposedRates'])
            ->where('status', 'negotiating')
            ->get();

        $results = [];

        // Step 1: Get min & max proposed rate for normalization
        $minRate = $responses->flatMap->proposedRates->min('proposed_rate');
        $maxRate = $responses->flatMap->proposedRates->max('proposed_rate');
        $range   = max(0.0001, $maxRate - $minRate);

        foreach ($responses as $response) {
            if ($response->proposedRates->count()) {

                
                $avgRate = $response->proposedRates->avg('proposed_rate');
                 // Get average rating from feedbacks
                $rating = $response->agency->averageRating(); // <-- use this
                $logoPath = $response->agency->profile->logo_path ?? 'images/default-logo.png';

                // Normalize average rate (lowest becomes 1.0, highest 0.0)
                $normalizedRate = ($maxRate - $avgRate) / $range;

                // Normalize rating (0–5 → 0–1)
                $normalizedRating = $rating / 5;

                // Apply DSS weights: 70% rate, 30% rating
                $score = (0.7 * $normalizedRate) + (0.3 * $normalizedRating);

                $results[] = [
                    'agency_id'     => $response->agency_id,
                    'agency_name'   => $response->agency->name ?? 'N/A',
                    'agency_logo'   => $logoPath,
                    'average_rate'  => $avgRate,
                    'rating'        => $rating,
                    'score'         => $score,
                ];
            }
        }

        // Sort by highest DSS score
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        $this->dssResults = $results;

        // Prepare explanation for top agency
        $top = $results[0] ?? null;
        if ($top) {
            $this->recommendedAgency = $top['agency_name'];
            $this->dssExplanation = sprintf(
                'Based on evaluation, <strong>%s</strong> achieved the highest overall score due to offering the lowest normalized average rate of <strong>₱%s</strong> and maintaining an agency rating of <strong>%.1f</strong>.',
                $top['agency_name'],
                number_format($top['average_rate'], 2),
                $top['rating']
            );
        }

        $this->showDssModal = true;
    }

    public function chooseAgency($agencyId)
    {
        if (in_array($agencyId, $this->selectedAgencyIds)) {
            $this->selectedAgencyIds = array_diff($this->selectedAgencyIds, [$agencyId]);
        } else {
            $this->selectedAgencyIds[] = $agencyId;
        }
    }


    public function proceedDssSelection()
    {
        $this->validate([
            'selectedAgencyIds' => 'required|array|min:1',
        ], [
            'selectedAgencyIds.required' => 'Please select at least one agency before proceeding.',
            'selectedAgencyIds.min' => 'Please select at least one agency before proceeding.',
        ]);

        // 👉 FETCH ALL RESPONSES ONCE
        $responses = $this->post->responses()->get();

        // mark selected agencies as 'accepted' and notify
        foreach ($this->selectedAgencyIds as $agencyId) {
            $response = $responses->where('agency_id', $agencyId)->first();
            if ($response) {
                $response->update(['status' => 'accepted']);

                // 🔔 CREATE NOTIFICATION FOR SELECTED AGENCY
                Notification::create([
                    'sender_id'   => Auth::id(), // company
                    'receiver_id' => $agencyId,  // agency
                    'message' => 'Your proposal was selected as the winner by ' .
                                $this->post->user->name .
                                ' for "' . $this->post->description . '"',
                ]);

            }
        }

        // mark unselected agencies (currently negotiating) as 'not_selected' and notify
        $notSelectedResponses = $responses
            ->where('status', 'negotiating')
            ->whereNotIn('agency_id', $this->selectedAgencyIds);

        foreach ($notSelectedResponses as $response) {
            $response->update(['status' => 'not_selected']);

            // 🔔 CREATE NOTIFICATION FOR NOT SELECTED AGENCY
            Notification::create([
                'sender_id'   => Auth::id(),               // company
                'receiver_id' => $response->agency_id,     // agency
                'message' => 'Your proposal was not selected by ' .
                            $this->post->user->name .
                            ' for "' . $this->post->description . '"',
            ]);
        }

        // ✅ Activity log for the company selecting the agency
                LogActivity::add(
                    'selected winner for post: "' . $this->post->description . '"',
                );

        $this->post->update(['status' => 'proposed']);

        $this->loadPost();
        $this->selectedAgencyIds = [];
        $this->showDssModal = false;

        session()->flash('success', 'Selected agencies marked as accepted.');
    }


    public function render()
    {
        // Always ensure fresh negotiating data in view
        $this->loadPost();
        return view('livewire.evaluate-proposals');
    }
}
