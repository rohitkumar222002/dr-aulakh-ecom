<?php
namespace App\Livewire\Site;

use Livewire\Component;

class Toast extends Component
{
    public $show = false;
    public $message = '';

    protected $listeners = ['toast' => 'showToast'];

    public function showToast($msg)
    {
        $this->message = $msg;
        $this->show = true;

        $this->dispatch('hide-toast-after-delay');
    }

    public function render()
    {
        return view('livewire.site.toast');
    }
}
