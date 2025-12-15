<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Notification;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;


class SelectProposals extends Component
{
    public $postId;
    public $post;
    public $showDssModal = false;
    public $dssResults = [];
    public $recommendedAgencies = [];
    public $selectedAgencyIds = [];

    public function mount($postId)
    {
        $this->post = Post::with(['responses.agency', 'responses.proposedRates.guardType'])
            ->findOrFail($postId);
    }

    public function openDssModal()
    {
        $responses = $this->post->responses()->with(['agency.profile', 'proposedRates'])->get();

        $results = [];

        $minRate = $responses->flatMap->proposedRates->min('proposed_rate');
        $maxRate = $responses->flatMap->proposedRates->max('proposed_rate');
        $range = max(0.0001, $maxRate - $minRate);

        foreach ($responses as $response) {
            if ($response->proposedRates->count()) {
                $avgRate = $response->proposedRates->avg('proposed_rate');
                $rating = $response->agency->averageRating();
                $logoPath = $response->agency->profile->logo_path ?? 'images/default-logo.png';

                $normalizedRate = ($maxRate - $avgRate) / $range;
                $normalizedRating = $rating / 5;

                $score = (0.7 * $normalizedRate) + (0.3 * $normalizedRating);

                $results[] = [
                    'agency_id' => $response->agency_id,
                    'agency_name' => $response->agency->name ?? 'N/A',
                    'agency_logo' => $logoPath,
                    'average_rate' => $avgRate,
                    'rating' => $rating,
                    'score' => $score,
                ];
            }
        }

        // Sort by score descending
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        $this->dssResults = $results;

        // pick top 3 agencies
        $this->recommendedAgencies = array_slice($results, 0, 3);

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
        ]);

        // 👉 FETCH ALL RESPONSES ONCE
        $responses = $this->post->responses()->get();

        // mark selected agencies as 'negotiating'
        foreach ($this->selectedAgencyIds as $agencyId) {
            $response = $responses->where('agency_id', $agencyId)->first();
            if ($response) {
                $response->update(['status' => 'negotiating']);

                Notification::create([
                    'sender_id'   => Auth::id(), // company
                    'receiver_id' => $agencyId,  // agency
                    'message' => 'Your proposal was selected as a candidate by ' .
                                    $this->post->user->name .
                                    ' for "' . $this->post->description . '"',
                ]);
            }
        }

        // mark unselected agencies as 'not_selected'
        $notSelectedResponses = $responses
            ->whereNotIn('agency_id', $this->selectedAgencyIds);

        foreach ($notSelectedResponses as $response) {
            $response->update(['status' => 'rejected']);

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
                'selected agencies as candidate for post: "' . $this->post->description . '"',
            );

        $this->post->update(['status' => 'proposed']);

        $this->showDssModal = false;

        session()->flash('success', 'Selected agencies are now marked as negotiating.');
    }

    public function render()
    {
        return view('livewire.select-proposals');
    }
}
