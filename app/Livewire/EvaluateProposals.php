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

        foreach ($responses as $response) {
            if ($response->proposedRates->count()) {
                
                // Compute average proposed rate
                $avgRate = $response->proposedRates->avg('proposed_rate');
                $rating = $response->agency->rating ?? 0;
                $logoPath = $response->agency->profile->logo_path ?? 'images/default-logo.png';

                 // DSS formula: weighted score (you can adjust weights)
                // Example: 70% importance to rate, 30% to rating (5 is best rating)
                $score = (0.7 * (1 / $avgRate)) + (0.3 * ($rating / 5));

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

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        $this->dssResults = $results;

        $top = $results[0] ?? null;
        if ($top) {
            $this->recommendedAgency = $top['agency_name'];
            $this->dssExplanation = sprintf(
                'Based on evaluation, <strong>%s</strong> obtained the highest overall score by offering the lowest average rate of <strong>₱%s</strong> and maintaining an agency rating of <strong>%.1f</strong>.',
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
