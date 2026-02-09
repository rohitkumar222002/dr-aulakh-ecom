<?php

namespace App\Http\Controllers\User;

use App\Models\Maid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function toUserDashboard()
    {
         $user = auth()->user();

        $directCount = $user->referrals()->count();

        $totalDownline = $this->countDownline($user);
        return view('user.home.dashboard', compact('directCount', 'totalDownline'));
    }
private function countDownline($user)
{
    $count = 0;

    foreach ($user->referrals as $referral) {
        $count += 1;
        $count += $this->countDownline($referral);
    }

    return $count;
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
      

            public function directReferrals()
{
    $user = auth()->user();

    $referrals = $user->referrals()
        ->select('id', 'name', 'username', 'email', 'created_at')
        ->latest()
        ->get();

    return view('user.direct-referrals', compact('referrals'));
}
public function downline(Request $request)
{
    $user = auth()->user();

    $selectedLevel = $request->level ?? 1;
    $search = $request->search;

    $users = $this->getDownlineByLevel($user, $selectedLevel);
            $levels = Level::orderBy('level')->get();
    if ($search) {
        $users = $users->filter(function ($u) use ($search) {
            return str_contains(strtolower($u->name), strtolower($search)) ||
                   str_contains(strtolower($u->username), strtolower($search)) ||
                   str_contains(strtolower($u->email), strtolower($search));
        });
    }

    return view('user.downline', [
        'users' => $users,
        'selectedLevel' => $selectedLevel,
        'levels' => $levels
    ]);
}
private function getDownlineByLevel($user, $level)
{
    if ($level == 1) {
        return $user->referrals;
    }

    $currentLevelUsers = collect([$user]);

    for ($i = 1; $i <= $level; $i++) {

        $nextLevel = collect();

        foreach ($currentLevelUsers as $u) {
            $nextLevel = $nextLevel->merge($u->referrals);
        }

        $currentLevelUsers = $nextLevel;
    }

    return $currentLevelUsers;
}

public function transactions(Request $request)
{
    $user = auth()->user();

    $query = Transaction::where('user_id', $user->id)
                ->latest();

    // Date filter (optional)
    if ($request->date_type) {

        switch ($request->date_type) {

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'week':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;

            case 'month':
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                break;
        }
    }

    $transactions = $query->paginate(15)->appends($request->all());

    return view('user.transactions', compact('transactions'));
}
    }
