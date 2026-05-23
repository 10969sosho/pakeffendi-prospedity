<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies to fix "Too many redirects" on Cloudflare/Load Balancers
        $middleware->trustProxies(at: '*');

        // SetLocale harus dijalankan lebih awal agar locale tersedia untuk semua request
        $middleware->web(prepend: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 419 CSRF Token Mismatch Error
        // Redirect admin to login, guest to home
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login')
                    ->with('error', 'Your session has expired. Please login again.');
            }
            return redirect()->route('home')
                ->with('error', 'Your session has expired. Please try again.');
        });

        // Handle 500 Server Error (only when APP_DEBUG=false)
        // Redirect admin to login, guest to home
        if (!config('app.debug')) {
            $exceptions->render(function (\Throwable $e, $request) {
                // Check if it's an HTTP exception (404, 403, 500, etc)
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    $statusCode = $e->getStatusCode();
                    // Only redirect for 500 errors, let Laravel handle 404, 403, etc normally
                    if ($statusCode === 500) {
                        if ($request->is('admin/*')) {
                            return redirect()->route('admin.login')
                                ->with('error', 'An error occurred. Please try again or contact administrator.');
                        }
                        return redirect()->route('home')
                            ->with('error', 'An error occurred. Please try again.');
                    }
                    // Return null for other HTTP status codes (404, 403, etc) to show default error pages
                    return null;
                }
                
                // For non-HTTP exceptions (database errors, etc), treat as 500 and redirect
                if ($request->is('admin/*')) {
                    return redirect()->route('admin.login')
                        ->with('error', 'An error occurred. Please try again or contact administrator.');
                }
                
                // Prevent infinite loop if error happens on home page
                if ($request->routeIs('home') || $request->is('/')) {
                    return null; // Let default error page show
                }

                return redirect()->route('home')
                    ->with('error', 'An error occurred. Please try again.');
            });
        }
    })->create();
