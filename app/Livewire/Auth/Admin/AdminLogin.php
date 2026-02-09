<?php

namespace App\Livewire\Auth\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    public $email;
    public $password;

    public function login()
    {
        // Validate the email and password fields
        $this->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:6',
        ]);

        // Prepare the credentials
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        // Attempt login
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        } else {
            // Flash an error message and redirect back on failed login
            session()->flash('error', 'Invalid credentials.');
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.auth.admin.admin-login');
    }
}
