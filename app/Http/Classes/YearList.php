<?php

namespace App\Http\Classes;

use Carbon\Carbon;

class YearList
{

    public static function yearList()
    {
        return [
            Carbon::now()->addYear("+543")->addYear("-2")->year,
            Carbon::now()->addYear("+543")->addYear("-1")->year,
            Carbon::now()->addYear("+543")->year,
            Carbon::now()->addYear("+543")->addYear("1")->year,
            Carbon::now()->addYear("+543")->addYear("2")->year,
        ];

    }


}
