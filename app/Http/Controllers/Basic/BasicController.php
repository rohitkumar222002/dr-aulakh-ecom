<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Inc\Notification;
use App\Models\Inc\YoutubeVideo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Packages\Package;

class BasicController extends Controller
{

    function toLogout()
    {
        Auth::guard(current_guard())->logout();
        request()->session()->invalidate(); // Invalidate the session
        request()->session()->regenerateToken(); // Regenerate the CSRF token for security
        return redirect()->route('site.index');
    }




 


   
}
