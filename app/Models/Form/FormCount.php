<?php

namespace App\Models\Form;

use App\Http\Classes\DateList;
use App\Http\Classes\TaxList;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class FormCount extends Model
{
    use HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;

    protected $table = 'form_count';
    protected $fillable = [
        'district_office_name',
        'district_office_id',
        'on_month',
        'on_year',
    ];

    public function getOnMonthAttribute()
    {
        $data_list = DateList::fullMonthList();
        return $data_list[$this->month] ?? null;
    }

    public function getOnYearAttribute()
    {
        return $this->year;
    }

    public function getTax01ServingFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_serving_form'] ?? null;
    }

    public function getTax01CodeHouseAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_code_house'] ?? null;
    }

    public function getTax02ServingFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_serving_form'] ?? null;
    }

    public function getTax02CountLandAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_count_land'] ?? null;
    }

    public function getTax03ServingFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_serving_form'] ?? null;
    }

    public function getTax03CountTabletAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_count_tablet'] ?? null;
    }

    public function getTax04CountLandAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_count_land'] ?? null;
    }

    public function getTax04CodeHouseAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_code_house'] ?? null;
    }

    public function getTax04TaxCustomerAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_tax_customer'] ?? null;
    }

}
