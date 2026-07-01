<?php

namespace App\Filament\Resources\Callbacks\Schemas;

use App\Containers\AppSection\Callback\Enums\CallbackStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class CallbackInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Контакты')
                    ->components([
                        TextEntry::make('name')
                            ->label('Имя')
                            ->placeholder('Не указано'),

                        TextEntry::make('phone')
                            ->label('Телефон')
                            ->copyable(),

                        TextEntry::make('created_at')
                            ->label('Дата заявки')
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(3),

                Section::make('Комментарий')
                    ->components([
                        TextEntry::make('comment')
                            ->label('Комментарий')
                            ->placeholder('Без комментария')
                            ->columnSpanFull(),
                    ]),

                Section::make('Источник')
                    ->components([
                        TextEntry::make('page_url')
                            ->label('Страница')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab()
                            ->copyable()
                            ->placeholder('Не указана'),

                        TextEntry::make('status')
                            ->label('Статус')
                            ->formatStateUsing(fn (CallbackStatus $state): string => $state->label())
                            ->badge()
                            ->color(fn (CallbackStatus $state): string => $state->color()),
                    ])
                    ->columns(2),
            ]);
    }
}
