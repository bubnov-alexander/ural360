<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Имя')
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('telegram_id')
                    ->label('Telegram ID')
                    ->integer()
                    ->minValue(1)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'integer' => 'Telegram ID должен быть числом.',
                        'min' => 'Telegram ID должен быть положительным.',
                    ]),

                TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->maxLength(255),
            ]);
    }
}
