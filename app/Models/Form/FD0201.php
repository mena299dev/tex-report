<?php

namespace App\Models\Form;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
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

    public function getTotalAmountAttribute(){
        return $this->tax_amount + $this->increment_amount;
    }

    public function getDateOfNoticeThAttribute(){
        return Carbon::parse($this->date_of_notice)->addYear(543)->toDateString();
    }
    public function getDateOfPaymentThAttribute(){
        return Carbon::parse($this->date_of_payment)->addYear(543)->toDateString();
    }
}
