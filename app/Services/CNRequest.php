<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CNRequest
{
    protected $server;
    protected $accessToken;
    protected $refreshToken;

    public function __construct()
    {
        $this->server = rtrim(Session::get('cloudnet.server'), '/');
        $this->accessToken = Session::get('cloudnet.access_token');
        $this->refreshToken = Session::get('cloudnet.refresh_token');
    }

    /**
     * Verify if the current access token is valid.
     */
    public function verifyToken(): bool
    {
        if (!$this->server || !$this->accessToken) {
            return false;
        }

        $response = Http::withToken($this->accessToken)
            ->withoutVerifying()
            ->get("{$this->server}/auth/verify");

        if ($response->successful()) {
            return true;
        }

        // Try refresh if we have a refresh token
        return $this->refreshToken ? $this->refreshToken() : false;
    }

    /**
     * Try to refresh the token.
     */
    public function refreshToken(): bool
    {
        $response = Http::withToken($this->refreshToken)
            ->withoutVerifying()
            ->get("{$this->server}/auth/refresh");

        if ($response->failed()) {
            return false;
        }

        $data = $response->json();
        if (!isset($data['accessToken'])) {
            return false;
        }

        // Save new token
        Session::put('cloudnet.access_token', $data['accessToken']);
        $this->accessToken = $data['accessToken'];

        return true;
    }

    /**
     * Make a GET request.
     */
    public function get(string $endpoint)
    {
        return Http::withToken($this->accessToken)
            ->withoutVerifying()
            ->get("{$this->server}{$endpoint}");
    }

    /**
     * Make a POST request.
     */
    public function post(string $endpoint, array $data = [])
    {
        return Http::withToken($this->accessToken)
            ->withoutVerifying()
            ->post("{$this->server}{$endpoint}", $data);
    }
}
