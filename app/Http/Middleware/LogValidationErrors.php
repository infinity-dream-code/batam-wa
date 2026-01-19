<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LogValidationErrors
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response->status() == 422 && $response->getContent()) {
            $data = json_decode($response->getContent(), true);

            if (isset($data['error'])) {
                Log::channel('validation')->error('Validation Error', [
                    'errors' => $data['error'],
                    'input' => $request->all(),
                    'user_id' => auth()->id(),
                    'url' => $request->url(),
                ]);
            }
        }

        return $response;
    }
}
