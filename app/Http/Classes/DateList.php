<?php

namespace App\Http\Classes;

use Carbon\Carbon;

class DateList
{

    public static function yearList($selected = false)
    {
        $yearList = [];
        for ($y = -5; $y <= 5; $y++) {
            $year = 2564 + $y;
            $yearList[$year] = $year;
        }
        return $yearList;
    }

    public static function fullMonthList()
    {
        return [1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน", 5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม", 9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม"];

    }

    public static function getMonth($month_id)
    {
       $list =  [1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน", 5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม", 9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม"];

       return $list[$month_id];

    }
}
