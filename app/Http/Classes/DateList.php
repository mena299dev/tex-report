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

    public static function getMonthShort($month_id)
    {
        $list =  [1 => "ม.ค.", 2 => "ก.พ.", 3 => "มี.ค.", 4 => "เม.ย", 5 => "พ.ค.", 6 => "มิ.ย.", 7 => "ก.ค.", 8 => "ส.ค.", 9 => "ก.ย.", 10 => "ต.ค.", 11 => "พ.ย.", 12 => "ธ.ค."];
        return $list[$month_id];
    }
}
