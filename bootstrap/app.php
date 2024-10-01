<?php declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Log\LogManager;
use App\Http\Middleware as LocalMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
    )
    ->withProviders([
        App\Providers\AppServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        Spatie\RouteAttributes\RouteAttributesServiceProvider::class
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => LocalMiddleware\Authenticate::class,
            'guest' => LocalMiddleware\RedirectIfAuthenticated::class
        ])->validateCsrfTokens([
            '*'
        ])->trustProxies('*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Exception $e): void {
            /** @var LogManager $logManager */
            $logManager = app(LogManager::class);

            $logManager->channel('db')
                ->error($e->getMessage(), [
                    'class' => $e::class,
                    'trace' => $e->getTraceAsString()
                ]);
        });
    })->create();
