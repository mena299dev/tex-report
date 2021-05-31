<?php

namespace App\Models\Form;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class FD0201 extends Model
{
    use HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;

    protected $table = 'financial_department_02_1';
    protected $fillable = [
        'sequence',
        'district',
        'district_office_name',
        'district_office_id',
        'defaulter_name',
        'defaulter_year',
        'tax_amount',
        'increment_amount',
        'date_of_notice',
        'date_of_payment',
        'remark',
    ];
}
