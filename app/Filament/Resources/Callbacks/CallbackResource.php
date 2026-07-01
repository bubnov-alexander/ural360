<?php

namespace App\Filament\Resources\Callbacks;

use App\Containers\AppSection\Callback\Models\CallbackRequest;
use App\Filament\Resources\Callbacks\Pages\ListCallbacks;
use App\Filament\Resources\Callbacks\Pages\ViewCallback;
use App\Filament\Resources\Callbacks\Schemas\CallbackInfolist;
use App\Filament\Resources\Callbacks\Tables\CallbacksTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

final class CallbackResource extends Resource
{
    protected static ?string $model = CallbackRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Phone;

    protected static string|UnitEnum|null $navigationGroup = 'Заявки';

    protected static ?string $navigationLabel = 'Заявки с сайта';

    protected static ?string $modelLabel = 'заявка с сайта';

    protected static ?string $pluralModelLabel = 'заявки с сайта';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'phone';

    public static function table(Table $table): Table
    {
        return CallbacksTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CallbackInfolist::configure($schema);
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canView(Model $record): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canReplicate(Model $record): bool
    {
        return false;
    }

    public static function canReorder(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCallbacks::route('/'),
            'view' => ViewCallback::route('/{record}'),
        ];
    }
}
