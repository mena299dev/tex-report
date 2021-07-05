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

class InitiationYearTax extends Model
{
    use HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;

    protected $table = 'initiation_year_tax';
    protected $fillable = [
        'district_office_name',
        'district_office_id',
        'year_of_money',
        'tax01_serving_form',
        'tax01_code_house',
        'tax02_serving_form',
        'tax02_count_land',
        'tax03_serving_form',
        'tax03_count_tablet',
        'tax04_count_land',
        'tax04_code_house',
        'tax04_tax_customer',
    ];

    public function getYearOfMoneyAttribute()
    {
        return $this->year;
    }

    public function getTax01Attribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['amount'] ?? 0;
    }

    public function getTax02Attribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['amount'] ?? 0;
    }

    public function getTax03Attribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['amount'] ?? 0;
    }

    public function getTax04Attribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['amount'] ?? 0;
    }


}
