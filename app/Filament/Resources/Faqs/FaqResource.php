<?php

namespace App\Filament\Resources\Faqs;

use App\Containers\AppSection\Faq\Models\Faq;
use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Faqs\Pages\EditFaq;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Filament\Resources\Faqs\Schemas\FaqForm;
use App\Filament\Resources\Faqs\Tables\FaqsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

final class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Контент';

    protected static ?string $navigationLabel = 'FAQ';

    protected static ?string $modelLabel = 'FAQ';

    protected static ?string $pluralModelLabel = 'FAQ';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return FaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
