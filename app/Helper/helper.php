<?php

use Otpless\OTPLessAuth;
use App\Models\Inc\Store;
use App\Models\Inc\Upload;
use App\Models\Inc\BusinessSetting;
use App\Models\Level;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = BusinessSetting::where('type', $key)->first();
        if ($key === 'gst_state') {
        return (int)$setting->value; 
    }

        return $setting == null ? $default : $setting->value;
    }
}


if (!function_exists('verify_and_login_user')) {
    function verify_and_login_user($username, $otp, $otp_orderId)
    {
        $clientId = env('OTPLESS_CLIENT_ID');
        $clientSecret = env('OTPLESS_CLIENT_SECRET');
        $otpless = new OtplessAuth();
        $phone = '91' . $username;

        try {
            $res = $otpless->verifyOtp($phone, '', $otp_orderId, $otp, $clientId, $clientSecret);
            $response = json_decode($res, true);
            return $response;
        } catch (\Exception $e) {
            return 'Error verifying OTP: ' . $e->getMessage();
        }
    }
}


if (!function_exists('sendOtp')) {
    function sendOtp($phone)
    {
        $clientId = env('OTPLESS_CLIENT_ID');
        $clientSecret = env('OTPLESS_CLIENT_SECRET');
        $otpLength = 4;
        $orderId = now()->format('YmdHis');
        $phone = '91' . $phone;
        try {
            $otpless = new OtplessAuth(); // Initialize it here
            $res = $otpless->sendOtp($phone, "", $orderId, "", "", $clientId, $clientSecret, $otpLength, "SMS");
            $response = json_decode($res, true);
            if (isset($response['success']) && $response['success'] === true) {
                session()->flash('message', 'OTP Sent Successfully On Phone.');
                return  $response;
            } else {
                session()->flash('error', 'Failed to send OTP.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while sending OTP: ' . $e->getMessage());
            return false;
        }
    }
}


// if (!function_exists('current_guard')) {
//     function current_guard()
//     {
//         $request = request();
//         $referer = $request->headers->get('referer'); // Retrieve the referer URL
//         // Check if the referer URL or path contains 'admin' and the user is authenticated with the admin guard
//         if (strpos($referer, 'admin') !== false && Auth::guard('admin')->check()) {
//             return 'admin';
//         }

//         // Check if the referer URL or path contains 'advertiser' and the user is authenticated with the advertiser guard
//         if (strpos($referer, 'advertiser') !== false && Auth::guard('advertiser')->check()) {
//             return 'advertiser';
//         }

//         if (strpos($referer, 'agent') !== false && Auth::guard('agent')->check()) {
//             return 'agent';
//         }

//         // Check if the user is authenticated with the default web guard
//         if (Auth::check()) {
//             return 'web';
//         }

//         return null; // Return null if no guards are authenticated
//     }
// }

if (!function_exists('current_guard')) {
    function current_guard()
    {
        $request = request();

        // Check if the user is authenticated with the admin guard or is accessing an admin URL
        if ($request->is('admin/*') && Auth::guard('admin')->check()) {
            return 'admin';
        }

        // Check if the user is authenticated with the advertiser guard or is accessing an advertiser URL
        if ($request->is('advertiser/*') && Auth::guard('advertiser')->check()) {
            return 'advertiser';
        }

        // Check if the user is authenticated with the agent guard or is accessing an agent URL
        if ($request->is('agent/*') && Auth::guard('agent')->check()) {
            return 'agent';
        }

        // Check if the user is authenticated with the web guard
        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null; // Return null if no guards are authenticated
    }
}


if (!function_exists('storedetail')) {
    function storedetail()
    {
        $store = Store::where('user_id', Auth::id())
            ->where('guard', current_guard())
            ->first();

        return $store ?: null;
    }
}


if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = (isHttps() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return $root;
    }
}

if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        return getBaseURL() . 'public/';
    }
}


if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset($path, $secure);
            // return app('url')->asset('public/' . $path, $secure);
        }
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return null;
    }
}

function getEmbedUrl($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $parsedUrl = parse_url($url);

        // Handle regular YouTube URLs
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (isset($queryParams['v'])) {
                return "https://www.youtube.com/embed/{$queryParams['v']}";
            }
        }

        // Handle YouTube Shorts URLs
        if (strpos($parsedUrl['path'], '/shorts/') === 0) {
            $shortId = trim(str_replace('/shorts/', '', $parsedUrl['path']), '/');
            return "https://www.youtube.com/embed/{$shortId}";
        }
    }

    return null; // Return null if the URL is invalid or doesn't contain a video ID
}



function calculateDiscountPercentage($mrp, $salePrice)
{
    if ($mrp > 0 && $salePrice !== null && $salePrice > 0 && $mrp > $salePrice) {
        $discountPercentage = (($mrp - $salePrice) / $mrp) * 100;
        return round($discountPercentage, 0); // Round to 2 decimal places for better readability
    } else {
        return 0; // No discount or invalid input
    }
}


if (!function_exists('formatUrl')) {
    /**
     * Remove 'http://' or 'https://' from a given URL.
     *
     * @param string $url
     * @return string
     */
    function formatUrl($url)
    {
        // Remove 'http://' or 'https://' from the URL
        return preg_replace('#^https?://#', '', rtrim($url, '/'));
    }
    
    
    // if (!function_exists('getEmbedUrl')) {
    //     function getEmbedUrl($url, $type)
    //     {
    //         // Check for YouTube
    //         if ($type == 'youtube') {
    //             preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
    //             return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
    //         }
    
    //         // Check for Facebook
    //         elseif ($type == 'facebook') {
    //             $embedUrl = "https://www.facebook.com/plugins/video.php?href=" . urlencode($url) . "&show_text=false";
    //             // Try fetching the Facebook video page to check if it's available
    //             $headers = @get_headers($url);
    //             if ($headers && strpos($headers[0], '200')) {
    //                 return $embedUrl;
    //             } else {
    //                 return null;  // Facebook video not available or restricted
    //             }
    //         }
    
    //         // Check for Instagram
    //         elseif ($type == 'instagram') {
    //             // Directly extract Instagram post ID using regex
    //             preg_match('/instagram\.com\/p\/([a-zA-Z0-9_-]+)/', $url, $matches);
    //             $postId = $matches[1] ?? null;
    //             return $postId ? "https://www.instagram.com/p/{$postId}/embed" : null;
    //         }
    
    //         // Return null for unsupported platforms
    //         return null;
    //     }
    // }
    
   
if (!function_exists('distributeCommission')) {

function distributeCommission($order)
{
    DB::transaction(function () use ($order) {

        $buyer = $order->user;
        if (!$buyer) return;

        $levels = Level::orderBy('level')->get();
        if ($levels->isEmpty()) return;

        $orderItems = $order->items;

        foreach ($orderItems as $item) {

            $product = $item->product;
            if (!$product) continue;

            $commissionPool = ($product->discount_price * $product->distribute / 100) * $item->quantity;

            if ($commissionPool <= 0) continue;

            $currentUser = $buyer;

            foreach ($levels as $level) {

                $upline = $currentUser->referrer;
                if (!$upline) break;

                $commissionAmount = $commissionPool * $level->percentage / 100;

                Transaction::create([
                    'user_id' => $upline->id,
                    'from_user_id' => $buyer->id,
                    'level' => $level->level,
                    'amount' => $commissionAmount,
                    'trx_type' => 'credit',
                    'trx_id' => uniqid(),
                    'note' => "Level {$level->level} commission ₹"
                        . number_format($commissionAmount, 2)
                        . " from {$buyer->username} (Order: {$order->order_number})",
                ]);

                $upline->increment('balance', $commissionAmount);

                $currentUser = $upline;
            }
        }
    });
}

}
}
