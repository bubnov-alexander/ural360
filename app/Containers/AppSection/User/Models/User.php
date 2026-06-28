<?php

namespace App\Containers\AppSection\User\Models;

use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

final class User extends ParentUserModel implements FilamentUser
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
