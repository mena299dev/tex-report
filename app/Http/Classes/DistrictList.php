<?php

namespace App\Http\Classes;

use App\Models\User;
use Carbon\Carbon;

class DistrictList
{
    public static function districtCode()
    {
        return User::all()->pluck('name', 'district_code')->toArray();
    }

    public static function getDistrictName($code)
    {
        return User::where('district_code',$code)->pluck('name', 'district_code')->toArray();
    }


}
