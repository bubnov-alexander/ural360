<?php

namespace App\Containers\AppSection\User\Data\Seeders;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

final class AdminSeeder_1 extends ParentSeeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            [
                'email' => config('filament.admin.email'),
            ],
            [
                'name' => config('filament.admin.name'),
                'password' => config('filament.admin.password'),
            ],
        );
    }
}
