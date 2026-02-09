<?php

namespace App\Livewire\Auth;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Register extends Component
{
    
    public $name;
    public $phone;
    public $email;
    public $password;
    public $password_confirmation;
    public $store;
    public $oldSessionId;

    public $redirect;

    public function mount($redirect = null)
    {
        $this->redirect = $redirect;
        $this->oldSessionId = session()->getId();
    }
  public function register()
{
    $this->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|min:3',
    ]);

    $oldSessionId = $this->oldSessionId;

    $user = User::create([
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'password' => bcrypt($this->password),
    ]);

    Auth::login($user);

    $this->mergeCartAfterLogin($oldSessionId);

    session()->flash('success', 'Register Successfully');

    if ($this->redirect === 'checkout') {
        return redirect()->route('checkout');
    }

    return redirect()->route('user.profile');
}



public function mergeCartAfterLogin($oldSessionId)
{
    $userId = auth()->id();

    \DB::transaction(function () use ($oldSessionId, $userId) {

        $sessionCartItems = Cart::where('session_id', $oldSessionId)->get();

        foreach ($sessionCartItems as $item) {

            $existing = Cart::where('user_id', $userId)
                            ->where('product_id', $item->product_id)
                            ->first();

            if ($existing) {
                
                // Merge quantity safely respecting stock
                $existing->quantity = min(
                    $existing->quantity + $item->quantity, 
                    $existing->product->stock_qty
                );

                // Do NOT overwrite existing price
                // Keep original price to maintain audit history

                $existing->save();

                // Remove guest item
                $item->delete();

            } else {

                // Convert guest cart to user cart safely
                $item->user_id = $userId;
                $item->session_id = null;

                // Ensure quantity does not exceed stock
                $item->quantity = min($item->quantity, $item->product->stock_qty);

                $item->save();
            }
        }
    });
}
    public function render()
    {
        return view('livewire.auth.register');
    }
}
