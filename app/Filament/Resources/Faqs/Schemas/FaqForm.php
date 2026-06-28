<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('FAQ')
                    ->schema([
                        TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn (Set $set, ?string $state): string => $set('slug', self::makeSlug($state)))
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated(false)
                            ->maxLength(255),

                        Toggle::make('is_published')
                            ->label('Опубликован')
                            ->inline(false)
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(1),

                Section::make('Вопросы')
                    ->schema([
                        Repeater::make('questions')
                            ->label('Вопросы')
                            ->relationship('questions')
                            ->schema([
                                TextInput::make('question')
                                    ->label('Вопрос')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Textarea::make('answer')
                                    ->label('Ответ')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),

                                Toggle::make('is_published')
                                    ->label('Опубликован')
                                    ->inline(false)
                                    ->default(true),
                            ])
                            ->addActionLabel('Добавить вопрос')
                            ->reorderable(false)
                            ->columns(1)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    private static function makeSlug(?string $title): string
    {
        $slug = Str::slug($title ?? '');

        return $slug !== '' ? $slug : 'faq';
    }
}
