<?php

namespace App\Filament\Resources\YstTravel;

use App\Containers\AppSection\YstTravel\Models\YstSupboardService;
use App\Filament\Resources\YstTravel\Concerns\ReadOnlyYstTravelResource;
use App\Filament\Resources\YstTravel\Pages\ListYstSupboardServices;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

final class YstSupboardServiceResource extends Resource
{
    use ReadOnlyYstTravelResource;

    protected static ?string $model = YstSupboardService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Squares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Телеграм бот';

    protected static ?string $navigationLabel = 'SUP-борды';

    protected static ?string $modelLabel = 'SUP-услуга YST';

    protected static ?string $pluralModelLabel = 'SUP-услуги YST';

    protected static ?int $navigationSort = 9050;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('order');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('order_id')->label('ID заказа')->sortable()->searchable(),
                TextColumn::make('order.customer_name')->label('Клиент')->placeholder('Заказ не найден')->searchable(),
                TextColumn::make('supboards_count')->label('Количество')->sortable(),
                TextColumn::make('price')->label('Цена')->money('RUB', divideBy: 1)->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYstSupboardServices::route('/'),
        ];
    }
}
