<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class EvaluateProposals extends Component
{
    public $postId;
    public $post;
    public $showDssModal = false;
    public $dssResults = [];
    public $recommendedAgency = null;
    public $dssExplanation;
    public $selectedAgencyId = null;

    public function mount($postId)
    {
        $this->post = Post::with(['responses.agency', 'responses.proposedRates.guardType'])
            ->findOrFail($postId);
    }

    public function openDssModal()
    {
        $responses = $this->post->responses()
            ->with(['agency.profile', 'proposedRates'])
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

    //  set selected agency temporarily
    public function chooseAgency($agencyId)
    {
        $this->selectedAgencyId = $agencyId;
    }

    public function proceedDssSelection()
    {
        $this->validate([
            'selectedAgencyId' => 'required',
        ], [
            'selectedAgencyId.required' => 'Please select an agency before proceeding.',
        ]);

        // find the selected response
        $response = $this->post->responses()
            ->where('agency_id', $this->selectedAgencyId)
            ->first();

        if ($response) {
            // update selected agency response to 'negotiating'
            $response->update(['status' => 'negotiating']);

            $this->post->responses()
               ->where('agency_id', '!=', $this->selectedAgencyId)
               ->update(['status' => 'not_selected']);

            // update the post itself to 'proposed'
            $this->post->update(['status' => 'proposed']);
        }

        // close the modal
        $this->showDssModal = false;

        // optional success message
        session()->flash('success', 'The selected agency is now marked as negotiating.');
    }

    public function render()
    {
        return view('livewire.evaluate-proposals');
    }
}
