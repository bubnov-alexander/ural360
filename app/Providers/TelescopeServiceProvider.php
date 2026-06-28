<?php

namespace App\Providers;

use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        $sampleRate = max(0, min(100, (int) env('TELESCOPE_SAMPLE_RATE', 10)));

        Telescope::filter(function (IncomingEntry $entry) use ($sampleRate): bool {
            if (
                $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isSlowQuery() ||
                $entry->hasMonitoredTag()
            ) {
                return true;
            }

            return $entry->isRequest() && random_int(1, 100) <= $sampleRate;
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function (User|null $user = null): bool {
            return app()->environment('local') || (bool) $user?->isSuperAdmin();
        });
    }
}
