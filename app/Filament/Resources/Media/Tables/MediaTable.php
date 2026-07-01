<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query
                ->where('mime_type', 'like', 'image/%')
                ->with('model'))
            ->columns([
                ImageColumn::make('preview')
                    ->label('Изображение')
                    ->getStateUsing(fn (Media $record): string => $record->getUrl())
                    ->height(72)
                    ->width(96),

                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('source')
                    ->label('Источник')
                    ->getStateUsing(fn (Media $record): string => self::sourceLabel($record))
                    ->searchable(['model_type', 'model_id'])
                    ->toggleable(),

                TextColumn::make('collection_name')
                    ->label('Коллекция')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextInputColumn::make('alt')
                    ->label('Alt')
                    ->getStateUsing(fn (Media $record): string => (string)$record->getCustomProperty('alt'))
                    ->updateStateUsing(function (Media $record, ?string $state): ?string {
                        $alt = trim((string)$state);

                        if ($alt === '') {
                            $record->forgetCustomProperty('alt');
                            $alt = null;
                        } else {
                            $record->setCustomProperty('alt', $alt);
                        }

                        $record->save();

                        return $alt;
                    })
                    ->rules(['nullable', 'string', 'max:255'])
                    ->extraInputAttributes(['style' => 'min-width: 320px']),

                TextColumn::make('file_name')
                    ->label('Файл')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('alt_status')
                    ->label('Alt')
                    ->options([
                        'filled' => 'Заполнен',
                        'empty' => 'Не заполнен',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'filled' => $query
                                ->whereNotNull('custom_properties->alt')
                                ->where('custom_properties->alt', '!=', ''),
                            'empty' => $query->where(function (Builder $query): void {
                                $query
                                    ->whereNull('custom_properties->alt')
                                    ->orWhere('custom_properties->alt', '');
                            }),
                            default => $query,
                        };
                    }),

                SelectFilter::make('collection_name')
                    ->label('Коллекция')
                    ->options(fn (): array => Media::query()
                        ->where('mime_type', 'like', 'image/%')
                        ->distinct()
                        ->orderBy('collection_name')
                        ->pluck('collection_name', 'collection_name')
                        ->all()),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Открыть')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->url(fn (Media $record): string => $record->getUrl())
                    ->openUrlInNewTab(),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    private static function sourceLabel(Media $media): string
    {
        $model = $media->getRelationValue('model');

        if (! $model instanceof Model) {
            return class_basename((string)$media->getAttribute('model_type'))
                . ' #' . $media->getAttribute('model_id');
        }

        $title = $model->getAttribute('title')
            ?? $model->getAttribute('name')
            ?? $model->getAttribute('slug')
            ?? null;

        return class_basename($model::class)
            . ' #' . $model->getKey()
            . ($title !== null ? ' - ' . $title : '');
    }
}
