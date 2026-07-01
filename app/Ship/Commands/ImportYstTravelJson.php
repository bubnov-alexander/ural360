<?php

namespace App\Ship\Commands;

use App\Ship\Parents\Commands\Command;
use Illuminate\Support\Facades\DB;
use JsonException;

final class ImportYstTravelJson extends Command
{
    protected $signature = 'yst-travel:import-json {path : Path to exported YST Travel JSON} {--prune : Delete rows missing from the JSON export}';

    protected $description = 'Import YST Travel SQLite export JSON into the yst_travel MySQL connection.';

    /**
     * @throws JsonException
     */
    public function handle(): int
    {
        $path = (string)$this->argument('path');

        if (! is_file($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $payload = json_decode((string)file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $tables = $payload['tables'] ?? [];
        $connection = DB::connection('yst_travel');

        $connection->transaction(function () use ($connection, $tables): void {
            $this->importTable($connection, 'admins', $tables['admins'] ?? [], [
                'id',
                'user_id',
            ]);

            $this->importTable($connection, 'routes', $tables['routes'] ?? [], [
                'id',
                'point_a',
                'point_b',
            ]);

            $this->importTable($connection, 'orders', $tables['orders'] ?? [], [
                'id',
                'date_arrival',
                'time_arrival',
                'date_departure',
                'time_departure',
                'route_id',
                'customer_name',
                'phone',
                'prepayment_status',
                'additional_wishes',
            ]);

            $this->importTable($connection, 'catamaran_services', $tables['catamaran_services'] ?? [], [
                'id',
                'order_id',
                'quantity',
                'price',
            ]);

            $this->importTable($connection, 'transfer_services', $tables['transfer_services'] ?? [], [
                'id',
                'order_id',
                'vehicle_type',
                'route_id',
                'persons_count',
                'driver_included',
                'price',
            ]);

            $this->importTable($connection, 'supboard_services', $tables['supboard_services'] ?? [], [
                'id',
                'order_id',
                'supboards_count',
                'price',
            ]);

            $this->importTable($connection, 'settings', $tables['settings'] ?? [], [
                'id',
                'key',
                'value',
            ]);
        });

        $this->info('YST Travel import completed.');

        return self::SUCCESS;
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @param array<int, string> $columns
     */
    private function importTable($connection, string $table, array $rows, array $columns): void
    {
        $ids = [];

        foreach ($rows as $row) {
            $data = [];

            foreach ($columns as $column) {
                $data[$column] = $row[$column] ?? null;
            }

            if (isset($data['prepayment_status'])) {
                $data['prepayment_status'] = (bool)$data['prepayment_status'];
            }

            if (isset($data['driver_included'])) {
                $data['driver_included'] = (bool)$data['driver_included'];
            }

            $id = (int)$data['id'];
            $ids[] = $id;

            $connection->table($table)->updateOrInsert(['id' => $id], $data);
        }

        if ($this->option('prune')) {
            $connection->table($table)
                ->when($ids !== [], fn ($query) => $query->whereNotIn('id', $ids))
                ->delete();
        }

        $this->line("{$table}: " . count($rows));
    }
}
