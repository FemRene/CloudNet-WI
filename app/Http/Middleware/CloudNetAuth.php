<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CloudNetAuth
{
    public function handle(Request $request, Closure $next)
    {
        $server = Session::get('cloudnet.server');
        $accessToken = Session::get('cloudnet.access_token');
        $refreshToken = Session::get('cloudnet.refresh_token');

        if (!$server || !$accessToken) {
            return redirect()->route('login.form');
        }

        try {
            // ✅ Verify access token
            $verifyResponse = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post("$server/auth/verify");

            if ($verifyResponse->successful()) {
                $data = $verifyResponse->json();
                $expiresAt = $data['expiresAt'] ?? 0;

                if ($expiresAt > now()->timestamp * 1000) {
                    // Token valid
                    return $next($request);
                }
            }

            // 🔄 Try refreshing token
            if ($refreshToken) {
                $refreshResponse = Http::post("$server/auth/refresh", [
                    'refreshToken' => $refreshToken
                ]);

                if ($refreshResponse->successful()) {
                    $tokens = $refreshResponse->json();
                    if (!empty($tokens['accessToken'])) {
                        Session::put('cloudnet.access_token', $tokens['accessToken']);
                        Session::put('cloudnet.refresh_token', $tokens['refreshToken'] ?? $refreshToken);
                        return $next($request);
                    }
                }
            }

        } catch (\Exception $e) {
            // Fail silently, redirect to login
        }

        Session::flush();
        return redirect()->route('login.form');
    }
}
