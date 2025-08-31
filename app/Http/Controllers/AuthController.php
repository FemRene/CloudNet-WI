<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $server = Session::get('cloudnet.server');
        $accessToken = Session::get('cloudnet.access_token');
        $refreshToken = Session::get('cloudnet.refresh_token');

        // Kein Token gesetzt → Login-Form anzeigen
        if (!$server || !$accessToken || !$refreshToken) {
            return view('auth.login');
        }

        try {
            // 1️⃣ Prüfen, ob Access Token noch gültig ist
            $verify = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post("$server/auth/verify")
                ->json();

            // Wenn gültig, direkt weiterleiten
            if (isset($verify['type']) && $verify['type'] === 'access') {
                return redirect()->intended('/dashboard');
            }

        } catch (\Exception $e) {
            // Token invalid → versuchen zu refreshen
            try {
                $refresh = Http::post("$server/auth/refresh", [
                    'refreshToken' => $refreshToken
                ])->json();

                $newAccessToken = $refresh['accessToken'] ?? null;
                $newRefreshToken = $refresh['refreshToken'] ?? null;

                if ($newAccessToken) {
                    Session::put('cloudnet.access_token', $newAccessToken);
                    Session::put('cloudnet.refresh_token', $newRefreshToken);
                    return redirect()->intended('/dashboard');
                }
            } catch (\Exception $ex) {
                // Refresh fehlgeschlagen → Login-Form anzeigen
            }
        }

        // Standardmäßig Login-Form anzeigen
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validierung der Inputs
        $request->validate([
            'server' => 'required|url',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $server = rtrim($request->input('server'), '/');
        $username = $request->input('username');
        $password = $request->input('password');
        $server = "$server/api/v3";

        try {
            // 1️⃣ Login via /auth mit Basic Auth
            $response = Http::withBasicAuth($username, $password)
                ->withoutVerifying()
                ->post("$server/auth");

            if ($response->failed()) {
                return back()->withErrors([
                    'login' => 'Login fehlgeschlagen. Status: '.$response->status()
                ]);
            }

            $data = $response->json();
            $accessToken = $data['accessToken']["token"] ?? null;
            $refreshToken = $data['refreshToken']["token"] ?? null;

            if (!$accessToken) {
                return back()->withErrors(['login' => 'Kein Access Token erhalten.']);
            }

            // JWT in Session speichern
            Session::put('cloudnet.server', $server);
            Session::put('cloudnet.access_token', $accessToken);
            Session::put('cloudnet.refresh_token', $refreshToken);

            // 2️⃣ Benutzerinfos abrufen über /user/{username}
            $userList = Http::withToken($accessToken)
                ->withoutVerifying()
                ->get("$server/user")
                ->json()['users'] ?? [];

            $ownUser = null;
            foreach ($userList as $u) {
                if ($u['username'] === $username) {
                    $ownUser = $u;
                    break;
                }
            }

            if (!$ownUser) {
                return back()->withErrors(['login' => 'Benutzerinfo konnte nicht gefunden werden.']);
            }

            Session::put('cloudnet.user', $ownUser);
            session(['cloudnet_logged_in' => true]);

            // Erfolgreich, weiterleiten
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return back()->withErrors([
                'login' => 'Fehler bei der Verbindung zum Server: '.$e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        session()->forget('cloudnet_logged_in');
        Session::flush();
        return redirect()->route('login.form');
    }
}
