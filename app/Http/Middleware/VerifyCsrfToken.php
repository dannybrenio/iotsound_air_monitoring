<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs that should be excluded from CSRF verification.
     *
     * ⚠️ Do not put leading slash here.
     */
    protected $except = [
      'send-reading',    // matches POST /send-reading
      'sensor-status',   // matches POST /sensor-status
    ];
}