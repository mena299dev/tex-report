<?php

namespace App\Http\Classes;

use Carbon\Carbon;

class TaxList
{
    public static function fromCountTaxList(){
        return [
            'tax01' => 'ภาษีโรงเรือนและที่ดิน',
            'tax02' => 'ภาษีบำรุ้งท้องที่',
            'tax03' => 'ภาษีป้าย',
            'tax04' => 'ภาษีที่ดินและสิ่งปลูกสร้าง',
        ];
    }


}
