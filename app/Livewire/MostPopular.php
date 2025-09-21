<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;


class MostPopular extends Component
{
    public $posts;

    public function mount() {
        $this->posts = Post::all(); // or any query
    }

    public function render()
    {
        return view('livewire.most-popular');
    }
}
