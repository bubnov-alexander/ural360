<?php

namespace App\Filament\Resources\YstTravel;

use App\Containers\AppSection\YstTravel\Models\YstAdmin;
use App\Filament\Resources\YstTravel\Concerns\ReadOnlyYstTravelResource;
use App\Filament\Resources\YstTravel\Pages\ListYstAdmins;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

final class YstAdminResource extends Resource
{
    use ReadOnlyYstTravelResource;

    protected static ?string $model = YstAdmin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Телеграм бот';

    protected static ?string $navigationLabel = 'Админы';

    protected static ?string $modelLabel = 'админ YST';

    protected static ?string $pluralModelLabel = 'админы YST';

    protected static ?int $navigationSort = 9070;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user_id')->label('Telegram user ID')->searchable()->copyable()->sortable(),
            ])
            ->defaultSort('id')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYstAdmins::route('/'),
        ];
    }
}
