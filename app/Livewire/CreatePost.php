<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{
    public $companyName = '';
    public $logo = '';
    public $featured = false;
    public $jobType = '';
    public $website = '';
    public $phone = '';
    public $email = '';
    public $description = '';
    public $requirements = '';
    public $location = '';
    public $needs = '';
    public $foundedIn = '';
    public $companySize = '';
    public $toast = null; // Holds the toast data
    public function submit()
    {
        // Validate form fields
        $this->validate([
            'companyName' => 'required|string',
            'logo' => 'nullable|string',
            'featured' => 'boolean',
            'website' => 'nullable|url',
            'phone' => 'required|string',
            'email' => 'required|email',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string',
            'needs' => 'required|string',
            'foundedIn' => 'nullable|date',
            'companySize' => 'nullable|string',
        ]);

        // Save to database
        Post::create([
            'company_name' => $this->companyName,
            'logo' => $this->logo,
            'featured' => $this->featured,
            'job_type' => $this->jobType,
            'website' => $this->website,
            'phone' => $this->phone,
            'email' => $this->email,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'location' => $this->location,
            'needs' => $this->needs,
            'founded_in' => $this->foundedIn,
            'company_size' => $this->companySize,
        ]);

        // Clear form
        $this->reset();

        // Set toast data
        $this->toast = [
            'type' => 'success',
            'message' => 'Job Post Submitted Successfully',
        ];
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
