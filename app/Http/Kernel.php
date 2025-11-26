<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     */
    protected $middleware = [
        // Handles trusted proxies
        \App\Http\Middleware\TrustProxies::class,

        // Handles CORS
        \Fruitcake\Cors\HandleCors::class,

        // Prevents requests during maintenance
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Validates POST request size
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Trims whitespace from strings
        \App\Http\Middleware\TrimStrings::class,

        // Converts empty strings to null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    protected $routeMiddleware = [
        // Laravel default auth middleware
        'auth' => \App\Http\Middleware\Authenticate::class,

        // Redirects authenticated users away from login pages
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Password confirmation
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Signed URLs
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Request throttling
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Bind route parameters
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // 🔐 CUSTOM ADMIN MIDDLEWARE
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
