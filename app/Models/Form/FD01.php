<?php

namespace App\Models\Form;

use App\Http\Classes\DateList;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class FD01 extends Model
{
    use HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;

    protected $table = 'financial_department_01';
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

    /////////Tax1


    public function getTax01EstimatedAmountFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_estimated_amount_form'] ?? null;
    }

    public function getTax01EstimatedAmountMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_estimated_amount_money'] ?? null;
    }

    public function getTax01AcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accept_payment_form'] ?? null;
    }

    public function getTax01AcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accept_payment_money'] ?? null;
    }

    public function getTax01AccountsReceivableBroughtForwardFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accounts_receivable_brought_forward_form'] ?? null;
    }

    public function getTax01AccountsReceivableBroughtForwardMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accounts_receivable_brought_forward_money'] ?? null;
    }


    public function getTax01AccountsReceivableAcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accounts_receivable_accept_payment_form'] ?? null;
    }

    public function getTax01AccountsReceivableAcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accounts_receivable_accept_payment_money'] ?? null;
    }

    public function getTax01AcceptPaymentMonthlyFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accept_payment_monthly_form'] ?? null;
    }

    public function getTax01AcceptPaymentMonthlyMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax01']['tax01_accept_payment_monthly_money'] ?? null;
    }


    /////////Tax2

    public function getTax02EstimatedAmountFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_estimated_amount_form'] ?? null;
    }

    public function getTax02EstimatedAmountMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_estimated_amount_money'] ?? null;
    }

    public function getTax02AcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accept_payment_form'] ?? null;
    }

    public function getTax02AcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accept_payment_money'] ?? null;
    }

    public function getTax02AccountsReceivableBroughtForwardFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accounts_receivable_brought_forward_form'] ?? null;
    }

    public function getTax02AccountsReceivableBroughtForwardMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accounts_receivable_brought_forward_money'] ?? null;
    }


    public function getTax02AccountsReceivableAcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accounts_receivable_accept_payment_form'] ?? null;
    }

    public function getTax02AccountsReceivableAcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accounts_receivable_accept_payment_money'] ?? null;
    }

    public function getTax02AcceptPaymentMonthlyFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accept_payment_monthly_form'] ?? null;
    }

    public function getTax02AcceptPaymentMonthlyMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax02']['tax02_accept_payment_monthly_money'] ?? null;
    }


    /////////Tax3

    public function getTax03EstimatedAmountFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_estimated_amount_form'] ?? null;
    }

    public function getTax03EstimatedAmountMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_estimated_amount_money'] ?? null;
    }

    public function getTax03AcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accept_payment_form'] ?? null;
    }

    public function getTax03AcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accept_payment_money'] ?? null;
    }

    public function getTax03AccountsReceivableBroughtForwardFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accounts_receivable_brought_forward_form'] ?? null;
    }

    public function getTax03AccountsReceivableBroughtForwardMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accounts_receivable_brought_forward_money'] ?? null;
    }


    public function getTax03AccountsReceivableAcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accounts_receivable_accept_payment_form'] ?? null;
    }

    public function getTax03AccountsReceivableAcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accounts_receivable_accept_payment_money'] ?? null;
    }

    public function getTax03AcceptPaymentMonthlyFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accept_payment_monthly_form'] ?? null;
    }

    public function getTax03AcceptPaymentMonthlyMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax03']['tax03_accept_payment_monthly_money'] ?? null;
    }


    /////////Tax4

    public function getTax04EstimatedAmountFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_estimated_amount_form'] ?? null;
    }

    public function getTax04EstimatedAmountMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_estimated_amount_money'] ?? null;
    }

    public function getTax04AcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accept_payment_form'] ?? null;
    }

    public function getTax04AcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accept_payment_money'] ?? null;
    }

    public function getTax04AccountsReceivableBroughtForwardFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accounts_receivable_brought_forward_form'] ?? null;
    }

    public function getTax04AccountsReceivableBroughtForwardMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accounts_receivable_brought_forward_money'] ?? null;
    }


    public function getTax04AccountsReceivableAcceptPaymentFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accounts_receivable_accept_payment_form'] ?? null;
    }

    public function getTax04AccountsReceivableAcceptPaymentMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accounts_receivable_accept_payment_money'] ?? null;
    }

    public function getTax04AcceptPaymentMonthlyFormAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accept_payment_monthly_form'] ?? null;
    }

    public function getTax04AcceptPaymentMonthlyMoneyAttribute()
    {
        $json = json_decode($this->json, true);
        return $json['tax04']['tax04_accept_payment_monthly_money'] ?? null;
    }


}
