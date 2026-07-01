<?php

namespace App\Filament\Resources\YstTravel;

use App\Containers\AppSection\YstTravel\Models\YstOrder;
use App\Filament\Resources\YstTravel\Concerns\ReadOnlyYstTravelResource;
use App\Filament\Resources\YstTravel\Pages\ListYstOrders;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

final class YstOrderResource extends Resource
{
    use ReadOnlyYstTravelResource;

    protected static ?string $model = YstOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Телеграм бот';

    protected static ?string $navigationLabel = 'Заказы';

    protected static ?string $modelLabel = 'заказ YST';

    protected static ?string $pluralModelLabel = 'заказы YST';

    protected static ?int $navigationSort = 9010;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('route');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('customer_name')->label('Клиент')->searchable()->sortable(),
                TextColumn::make('phone')->label('Телефон')->searchable()->copyable(),
                TextColumn::make('route_label')
                    ->label('Маршрут')
                    ->getStateUsing(fn (Model $record): ?string => $record->route?->title)
                    ->placeholder('Не указан'),
                TextColumn::make('date_arrival')->label('Дата прибытия')->sortable(),
                TextColumn::make('time_arrival')->label('Время прибытия')->toggleable(),
                TextColumn::make('date_departure')->label('Дата отъезда')->sortable(),
                TextColumn::make('time_departure')->label('Время отъезда')->toggleable(),
                IconColumn::make('prepayment_status')->label('Предоплата')->boolean()->sortable(),
                TextColumn::make('additional_wishes')->label('Пожелания')->limit(60)->toggleable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYstOrders::route('/'),
        ];
    }
}
