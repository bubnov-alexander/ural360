<?php

namespace App\Filament\Resources\Callbacks\Tables;

use App\Containers\AppSection\Callback\Enums\CallbackStatus;
use App\Containers\AppSection\Callback\Models\CallbackRequest;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CallbacksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Имя')
                    ->placeholder('Не указано')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->limit(60)
                    ->placeholder('Без комментария')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('page_url')
                    ->label('Страница')
                    ->limit(40)
                    ->url(fn (?string $state): ?string => $state)
                    ->openUrlInNewTab()
                    ->placeholder('Не указана')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->formatStateUsing(fn (CallbackStatus $state): string => $state->label())
                    ->badge()
                    ->color(fn (CallbackStatus $state): string => $state->color())
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('change_status')
                    ->label('Сменить статус')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->schema([
                        Select::make('status')
                            ->label('Статус')
                            ->options(CallbackStatus::options())
                            ->required(),
                    ])
                    ->fillForm(fn (CallbackRequest $record): array => [
                        'status' => $record->status->value,
                    ])
                    ->action(function (CallbackRequest $record, array $data): void {
                        $record->status = CallbackStatus::from((int)$data['status']);
                        $record->save();
                    }),

                ViewAction::make(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100]);
    }
}
