<?php

namespace App\Livewire\Site\Pages;

use App\Models\Inc\CustomPages;
use Livewire\Component;

class CustomPagesComponent extends Component
{

    public $page;

    public function mount($slug)
    {
        $this->page = CustomPages::where('slug', $slug)->where('status', 1)->first();

        if (!$this->page) {
            return redirect()->route('error');
        }
    }
    public function render()
    {
        return view('livewire.site.pages.custom-pages-component');
    }
}
