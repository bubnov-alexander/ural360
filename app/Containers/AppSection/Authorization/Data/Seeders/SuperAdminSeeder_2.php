<?php

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

final class SuperAdminSeeder_2 extends ParentSeeder
{
    public function run(RoleRepository $roleRepository): void
    {
        $user = User::query()->firstOrNew([
            'email' => config('filament.admin.email'),
        ]);

        $user->name = config('filament.admin.name');
        $user->password = config('filament.admin.password');
        $user->markEmailAsVerified();
        $user->save();

        $roleRepository->makeSuperAdmin($user);
    }
}
