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
public $referral_id;

    public $sponsorExists = false;
    public $sponsorName;
    public $createUser = false;
    public $redirect;

    public function mount($redirect = null)
    {
        $this->redirect = $redirect;
        $this->oldSessionId = session()->getId();
        $this->referral_id = request('referral') ?? '';

    if ($this->referral_id) {
        $this->checkSponsor();
    }
    }
  public function register()
{
    $this->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|min:3',
    'referral_id' => 'nullable|exists:users,username',
    ]);
    $referrer = null;
    $username = 'THL' . str_pad(User::max('id') + 1, 4, '0', STR_PAD_LEFT);
    
    if ($this->referral_id) {
        $referrer = User::where('username', $this->referral_id)->first();
        }
    $oldSessionId = $this->oldSessionId;

    $user = User::create([
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'referral_id' => $referrer->id ?? 1,
        'username' => $username,
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

public function checkSponsor()
    {
        if ($this->referral_id) {
            $user = User::where('username', $this->referral_id)->first();

            if ($user) {
                $this->sponsorExists = true;
                $this->sponsorName = $user->name;
                $this->createUser = true;
            } else {
                $this->sponsorExists = false;
                $this->sponsorName = null;
                $this->createUser = false;
            }
        } else {
            $this->sponsorExists = false;
            $this->createUser = false;
        }
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
