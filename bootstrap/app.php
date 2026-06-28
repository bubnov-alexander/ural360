<?php

use Apiato\Foundation\Apiato;
use Apiato\Http\Middleware\ProcessETag;
use Apiato\Http\Middleware\ValidateJsonContent;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\TelescopeServiceProvider;
use App\Ship\Middleware\ValidateAppId;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$basePath = dirname(__DIR__);
$apiato = Apiato::configure(basePath: $basePath)->create();

return Application::configure(basePath: $basePath)
    ->withProviders([
        ...$apiato->providers(),
        AdminPanelProvider::class,
        TelescopeServiceProvider::class,
    ])
    ->withEvents($apiato->events())
    ->withRouting(
        web: $apiato->webRoutes(),
        channels: __DIR__ . '/../app/Ship/Broadcasting/channels.php',
        health: '/up',
        then: static fn () => $apiato->registerApiRoutes(),
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            ValidateAppId::class,
        ]);
        $middleware->api(append: [
            ValidateJsonContent::class,
            ProcessETag::class,
        ]);
        $middleware->redirectUsersTo(static function (Request $request): string {
            return '/admin';
        });
        $middleware->redirectGuestsTo(static function (Request $request): string {
            return '/admin/login';
        });
    })
    ->withCommands($apiato->commands())
    ->withSchedule(static function (Schedule $schedule): void {
        $schedule->command('telescope:prune --hours=6')->hourly();
    })
    ->withExceptions(static function (Exceptions $exceptions) {})
    ->create();
