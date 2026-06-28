<?php

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Settings\ContactSettings;
use Illuminate\Support\Facades\DB;

final class UpsertContactSettingsTask
{
    /**
     * @param array<string, mixed> $settings
     */
    public function run(array $settings): void
    {
        $now = now();

        $rows = collect($settings)
            ->map(fn (mixed $payload, string $name): array => [
                'group' => ContactSettings::group(),
                'name' => $name,
                'locked' => false,
                'payload' => json_encode($payload),
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->values()
            ->all();

        DB::table(config('settings.repositories.database.table') ?? 'settings')
            ->upsert($rows, ['group', 'name'], ['payload', 'updated_at']);
    }
}
