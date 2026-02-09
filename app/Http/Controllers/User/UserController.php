<?php

namespace App\Http\Controllers\User;

use App\Models\Maid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function toUserDashboard()
    {
        return view('user.home.dashboard');
    }

    public function UserProfile()
    {
        $profile = Auth::user();
        return view('user.profile.profile', compact('profile')); // Change to user profile view
    }

    public function UserProfileUpdate(Request $request)
    {
        $request->validate(
            [
                'full_name' => 'nullable',
                'email' => 'nullable|email',
                'phone' => 'required|digits:10|unique:users,phone,' . Auth::id(), // Ignore current user ID for phone uniqueness
                'address' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'country' => 'nullable',
                'image' => 'nullable',
                'user_pin' => 'required|min:6|max:6',
            ],
            [
                'user_pin.required' => 'The PIN is required. Please provide a 6-digit PIN.',
                'user_pin.min' => 'The PIN must be exactly 6 digits.',
                'user_pin.max' => 'The PIN must not exceed 6 digits.',
            ]
        );

        $user = Auth::user();
        $user->name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->phone_2 = $request->input('phone_2');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->avatar = $request->input('image');
        $user->user_pin = $request->user_pin;
        $user->password = Hash::make($request->user_pin);
        $user->save();
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

   

    function toepingenerate(Request $request)
    {
        $request->validate([
            'user_pin' => 'required|string|digits:6',
        ]);
        $user = Auth::user();
        $user->user_pin = $request->user_pin;
        $user->password = Hash::make($request->user_pin);
        if ($user->save()) {
            return redirect()->back()->with('success', 'E-Pin generated successfully.');
        }
        return redirect()->back()->with('error', 'E-Pin generation failed.');
    }
        public function Maids(){
                $maids = Maid::where('status', 1)->paginate(100);
                return view('user.maids.index', compact('maids'));
            }
    }
