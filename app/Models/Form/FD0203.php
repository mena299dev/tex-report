<?php

namespace App\Models\Form;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class FD0203 extends Model
{
    use HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;

    protected $table = 'financial_department_02_3';
    protected $fillable = [
        'sequence',
        'district',
        'district_office_name',
        'district_office_id',
        'defaulter_name',
        'defaulter_year',
        'tax_amount',
        'receive_number',
        'surveying_number',
        'date_of_notice',
        'date_of_payment',
        'remark',
    ];

    public function getTotalAmountAttribute(){
        return $this->tax_amount + $this->increment_amount;
    }
}
