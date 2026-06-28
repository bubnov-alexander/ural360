<?php

namespace App\Filament\Components;

use App\Containers\AppSection\Seo\Models\Seo;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs\Tab;

final class SEOTab
{
    public static function getSeoTab(): Tab
    {
        return Tab::make('seo-tab')
            ->columns(2)
            ->label('SEO')
            ->schema([
                Fieldset::make('SEO-настройки')
                    ->relationship('seo')
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок в поиске')
                            ->maxLength(191),

                        TextInput::make('og_title')
                            ->label('Заголовок в мессенджерах')
                            ->maxLength(191),

                        Textarea::make('description')
                            ->label('Описание в поиске')
                            ->maxLength(255),

                        Textarea::make('og_description')
                            ->label('Описание в мессенджерах')
                            ->maxLength(255),

                        Textarea::make('keywords')
                            ->label('Ключевые слова')
                            ->helperText('Ключевые слова через запятую или абзацы')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('og_image')
                            ->label('Изображение')
                            ->collection(Seo::MEDIA_COLLECTION_SEO_IMAGE)
                            ->image()
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Максимальный размер: 5Мб. Формат: .jpg, .png, .webp')
                            ->downloadable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
