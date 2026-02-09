<?php

// app/Http/Middleware/RemoveWwwMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RemoveWwwMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($this->shouldRedirect($request)) {
            $url = $request->url();
            $newUrl = $this->removeWww($url);
            return redirect()->to($newUrl, 301);
        }

        return $next($request);
    }

    protected function shouldRedirect($request)
    {
        return Str::startsWith($request->url(), 'https://www.');
    }

    protected function removeWww($url)
    {
        return Str::replaceFirst('https://www.', 'https://', $url);
    }
}

