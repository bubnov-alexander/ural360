<?php

namespace App\Filament\Resources\YstTravel\Pages;

use App\Filament\Resources\YstTravel\YstSettingResource;
use Filament\Resources\Pages\ListRecords;

final class ListYstSettings extends ListRecords
{
    protected static string $resource = YstSettingResource::class;
}
