<?php
namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Lang;

class CustomThrottleRequests extends ThrottleRequests
{
    protected function buildResponse($key, $maxAttempts)
    {
        $retryAfter = $this->limiter->availableIn($key);

        return response()->json([
            'message' => Lang::get('messages.too_many_attempts', ['seconds' => $retryAfter]),
        ], 429);
    }
}
