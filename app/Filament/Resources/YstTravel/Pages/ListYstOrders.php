<?php

namespace App\Filament\Resources\YstTravel\Pages;

use App\Filament\Resources\YstTravel\YstOrderResource;
use Filament\Resources\Pages\ListRecords;

final class ListYstOrders extends ListRecords
{
    protected static string $resource = YstOrderResource::class;
}
