<?php
namespace App\Livewire\Auth;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Login extends Component
{
public $redirect;

    public $email;
    public $password;
    public $oldSessionId;
    public $remember = false;
        public function mount($redirect = null)
        {
            $this->redirect = $redirect;
            
    $this->oldSessionId = session()->getId();
        }
    public function login()
{
    $this->validate([
        'email' => 'required|exists:users,email',
        'password' => 'required',
    ]);

    $oldSessionId = $this->oldSessionId;
    $user = User::where('email', $this->email)
                ->where('status', 1)
                ->first();

    if (!$user) {
        session()->flash('error', 'Your account is inactive or does not exist.');
        return;
    }

    $credentials = [
        'email' => $this->email,
        'password' => $this->password,
    ];

    if (Auth::attempt($credentials, $this->remember)) {

        $this->mergeCartAfterLogin($oldSessionId);
        if ($this->redirect === 'checkout') {
        
            return redirect()->route('checkout');
        }

        return redirect()->route('user.dashboard');
    }

    session()->flash('error', 'Invalid credentials.');
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
        return view('livewire.auth.login');
    }
}

