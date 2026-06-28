<?php

namespace App\Filament\Pages;

use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Settings\Tasks\UpsertContactSettingsTask;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ContactSettingsPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?string $navigationLabel = 'Контакты и карта';

    protected static ?string $title = 'Контакты и карта';

    protected static ?string $slug = 'settings/contacts';

    protected static ?int $navigationSort = 20;

    protected string $view = 'filament.pages.contact-settings-page';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(ContactSettings $settings): void
    {
        $this->form->fill([
            'site_name' => $settings->site_name,
            'site_url' => $settings->site_url,
            'home_url' => $settings->home_url,
            'phone' => $settings->phone,
            'email' => $settings->email,
            'recipient_email' => $settings->recipient_email,
            'address' => $settings->address,
            'yandex_map_key' => $settings->yandex_map_key,
            'yandex_map_script' => $settings->yandex_map_script,
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Сайт')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Название сайта')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('site_url')
                            ->label('URL сайта')
                            ->url()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('home_url')
                            ->label('URL главной')
                            ->url()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(1),

                Section::make('Контакты')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel()
                            ->required()
                            ->maxLength(50),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('recipient_email')
                            ->label('Email для заявок')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Textarea::make('address')
                            ->label('Адрес')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000),
                    ])
                    ->columns(1),

                Section::make('Яндекс.Карта')
                    ->schema([
                        TextInput::make('yandex_map_key')
                            ->label('Ключ карты')
                            ->maxLength(255),

                        Textarea::make('yandex_map_script')
                            ->label('Embed-скрипт')
                            ->rows(6)
                            ->maxLength(5000),
                    ])
                    ->columns(1),
            ]);
    }

    public function save(UpsertContactSettingsTask $task): void
    {
        $data = $this->form->getState();

        $task->run([
            'site_name' => $data['site_name'],
            'site_url' => $data['site_url'],
            'home_url' => $data['home_url'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'recipient_email' => $data['recipient_email'],
            'address' => $data['address'],
            'yandex_map_key' => $data['yandex_map_key'] ?: null,
            'yandex_map_script' => $data['yandex_map_script'] ?: null,
        ]);

        Notification::make()
            ->title('Настройки сохранены')
            ->success()
            ->send();
    }

}
