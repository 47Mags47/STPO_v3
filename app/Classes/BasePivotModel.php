<?php

namespace App\Classes;

use App\Traits\ModelMethods;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BasePivotModel extends Pivot
{
    use ModelMethods;
}
