<?php

namespace App\Filament\Resources\YstTravel;

use App\Containers\AppSection\YstTravel\Models\YstSetting;
use App\Filament\Resources\YstTravel\Concerns\ReadOnlyYstTravelResource;
use App\Filament\Resources\YstTravel\Pages\ListYstSettings;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

final class YstSettingResource extends Resource
{
    use ReadOnlyYstTravelResource;

    protected static ?string $model = YstSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Телеграм бот';

    protected static ?string $navigationLabel = 'Настройки';

    protected static ?string $modelLabel = 'настройка YST';

    protected static ?string $pluralModelLabel = 'настройки YST';

    protected static ?int $navigationSort = 9060;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('key')->label('Ключ')->searchable()->sortable(),
                TextColumn::make('value')->label('Значение')->searchable(),
            ])
            ->defaultSort('id')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYstSettings::route('/'),
        ];
    }
}
