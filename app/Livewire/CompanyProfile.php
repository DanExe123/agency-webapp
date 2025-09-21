<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CompanyProfile extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }


    public function render()
    {
        return view('livewire.company-profile');
    }
}
