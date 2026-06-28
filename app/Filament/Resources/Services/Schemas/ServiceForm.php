<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Containers\AppSection\Service\Models\Service;
use App\Filament\Components\SEOTab;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Service tabs')
                    ->tabs([
                        Tab::make('Основное')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Название')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old): void {
                                        $set('slug', self::makeSlug($state));
                                        self::fillSeoTitle($get, $set, $state, $old);
                                    })
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->maxLength(255),

                                SpatieMediaLibraryFileUpload::make('image')
                                    ->label('Изображение')
                                    ->collection(Service::MEDIA_COLLECTION_SERVICE_IMAGE)
                                    ->image()
                                    ->maxSize(5120)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Максимальный размер: 5Мб. Формат: .jpg, .png, .webp')
                                    ->downloadable(),

                                Toggle::make('is_published')
                                    ->label('Опубликована')
                                    ->inline(false)
                                    ->default(true)
                                    ->required(),

                                Textarea::make('content')
                                    ->label('Контент')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old): void {
                                        self::fillSeoDescription($get, $set, $state, $old);
                                    })
                                    ->rows(12)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        SEOTab::getSeoTab(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function makeSlug(?string $title): string
    {
        $slug = Str::slug($title ?? '');

        return $slug !== '' ? $slug : 'service';
    }

    private static function fillSeoTitle(Get $get, Set $set, ?string $title, ?string $oldTitle): void
    {
        $title = trim((string)$title);
        $oldTitle = trim((string)$oldTitle);

        if ($title === '') {
            return;
        }

        foreach (['seo.title', 'seo.og_title'] as $field) {
            $current = trim((string)$get($field));

            if ($current === '' || $current === $oldTitle) {
                $set($field, $title);
            }
        }
    }

    private static function fillSeoDescription(Get $get, Set $set, ?string $content, ?string $oldContent): void
    {
        $description = self::makeSeoDescription($content);

        if ($description === null) {
            return;
        }

        $oldDescription = self::makeSeoDescription($oldContent);

        foreach (['seo.description', 'seo.og_description'] as $field) {
            $current = trim((string)$get($field));

            if ($current === '' || $current === $oldDescription) {
                $set($field, $description);
            }
        }
    }

    private static function makeSeoDescription(?string $content): ?string
    {
        $content = trim((string)$content);

        if ($content === '') {
            return null;
        }

        $text = trim((string)preg_replace('/\s+/', ' ', strip_tags($content)));

        return $text !== '' ? Str::limit($text, 255, '') : null;
    }
}
