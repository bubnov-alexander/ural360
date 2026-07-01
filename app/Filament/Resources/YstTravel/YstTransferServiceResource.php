<?php

namespace App\Filament\Resources\YstTravel;

use App\Containers\AppSection\YstTravel\Models\YstTransferService;
use App\Filament\Resources\YstTravel\Concerns\ReadOnlyYstTravelResource;
use App\Filament\Resources\YstTravel\Pages\ListYstTransferServices;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

final class YstTransferServiceResource extends Resource
{
    use ReadOnlyYstTravelResource;

    protected static ?string $model = YstTransferService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static string|UnitEnum|null $navigationGroup = 'Телеграм бот';

    protected static ?string $navigationLabel = 'Трансферы';

    protected static ?string $modelLabel = 'трансфер YST';

    protected static ?string $pluralModelLabel = 'трансферы YST';

    protected static ?int $navigationSort = 9040;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['order', 'route']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('order_id')->label('ID заказа')->sortable()->searchable(),
                TextColumn::make('order.customer_name')->label('Клиент')->placeholder('Заказ не найден')->searchable(),
                TextColumn::make('vehicle_type')->label('Транспорт')->searchable()->sortable(),
                TextColumn::make('route_label')
                    ->label('Маршрут')
                    ->getStateUsing(fn (Model $record): ?string => $record->route?->title)
                    ->placeholder('Не указан'),
                TextColumn::make('persons_count')->label('Человек')->sortable(),
                IconColumn::make('driver_included')->label('Водитель')->boolean()->sortable(),
                TextColumn::make('price')->label('Цена')->money('RUB', divideBy: 1)->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYstTransferServices::route('/'),
        ];
    }
}
