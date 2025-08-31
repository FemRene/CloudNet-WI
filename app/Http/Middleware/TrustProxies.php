<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * Use '*' to trust all proxies (Caddy in this case).
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * HEADER_X_FORWARDED_ALL ensures Laravel correctly reads:
     * - original client IP
     * - original scheme (http/https)
     * - original host
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
