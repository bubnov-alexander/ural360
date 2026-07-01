<?php

namespace App\Containers\AppSection\YstTravel\Models;

use App\Ship\Parents\Models\Model as ParentModel;

abstract class YstTravelModel extends ParentModel
{
    protected $connection = 'yst_travel';

    public $timestamps = false;
}
