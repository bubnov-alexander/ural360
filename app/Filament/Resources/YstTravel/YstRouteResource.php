<?php

namespace App\Filament\Resources\YstTravel;

use App\Containers\AppSection\YstTravel\Models\YstRoute;
use App\Filament\Resources\YstTravel\Concerns\ReadOnlyYstTravelResource;
use App\Filament\Resources\YstTravel\Pages\ListYstRoutes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

final class YstRouteResource extends Resource
{
    use ReadOnlyYstTravelResource;

    protected static ?string $model = YstRoute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;

    protected static string|UnitEnum|null $navigationGroup = 'Телеграм бот';

    protected static ?string $navigationLabel = 'Маршруты';

    protected static ?string $modelLabel = 'маршрут YST';

    protected static ?string $pluralModelLabel = 'маршруты YST';

    protected static ?int $navigationSort = 9020;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('point_a')->label('Точка A')->searchable()->sortable(),
                TextColumn::make('point_b')->label('Точка B')->searchable()->sortable(),
                TextColumn::make('orders_count')->label('Заказов')->counts('orders')->sortable(),
            ])
            ->defaultSort('id')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYstRoutes::route('/'),
        ];
    }
}
