<?php

namespace App\Http\Controllers\Report;

use App\Http\Classes\DateList;
use App\Http\Classes\DistrictList;
use App\Models\Form\FD01;
use App\Models\Form\InitiationYearTax;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;


class FD01Controller extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function index(Request $request)
    {
        $user = backpack_user();
        $selected_month = $request->input('on_month') ?? Carbon::now()->addMonth(-1)->month;
        $selected_year = $request->input('on_year') ?? Carbon::now()->addYear(543)->year;
        $selected_district = $request->input('district') ?? $user->district_code;


        $month_list[0] = 'กรุณาเลือกเดือน';
        foreach (DateList::fullMonthList() as $m_key => $m) {
            $month_list[$m_key] = $m;
        }

        $year_list[0] = 'กรุณาเลือกปี';
        foreach (DateList::yearList() as $y_key => $y) {
            $year_list[$y_key] = $y;
        }

        $district_list[0] = 'กรุณาเลือกเขต';
        foreach (DistrictList::districtCode() as $d_key => $d) {
            $district_list[$d_key] = $d;
        }

        $fd = FD01::select('*')
            ->where('year', $selected_year)
            ->where('month', $selected_month)
            ->where('district_office_id', $selected_district)
            ->first();

        $InitiationYearTax = InitiationYearTax:: select('*')
            ->where('year', $selected_year)
            ->where('district_office_id', $selected_district)
            ->first();

        $data['title'] = 'รายงาน สนค.01';
        $data['district'] = $district_list;
        $data['month_list'] = $month_list;
        $data['year_list'] = $year_list;
        $data['selected'] = [
            "selected_month" => $selected_month != 0 ? DateList::getMonth($selected_month) : null,
            "selected_month_short" => $selected_month != 0 ? DateList::getMonthShort($selected_month) : null,
            "selected_year" => $selected_year ?? null,
            "selected_year_short" => Str::substr($selected_year, -2, 2) ?? null,
            "selected_district" => $selected_district != 0 ? DistrictList::getDistrictName($selected_district)[$selected_district] : null
        ];

        $data['fd'] = $fd;
        $data['cumulative_year'] = $this->getCumulativeByYear($selected_year, $selected_month, $selected_district);
        $data['initiation_year_tax'] = $InitiationYearTax;


        if ($request->input('debug') == 'dev') {
            return $data;
        }

        if ($request->input('btn_type') == 'download') {
            switch ($request->input('download_type')) {
                case "excel" :
                    return self::exportExcel($data);
                default :
                    return self::exportPDF($data, $InitiationYearTax);
            }
        }

        return view('report.fd01')->with($data);
//        return view('export.fd02-01')->with($data);
    }

    public function getCumulativeByYear($year, $select_month = null, $selected_district = null)
    { // 1 รอบปีงบ ตุลาปีก่อนหน้า 10  ถึง กันยาปีปัจจุบัน(ปีที่เลือก) 9
        $user = backpack_user();
        $selected_district = $selected_district ?? $user->district_code;
        $previous_year = $year - 1;
        $select_month = $select_month === null ? Carbon::now()->addMonth(-1)->month : $select_month;

        $fd = FD01::select('*')
            ->where(function ($q) use ($previous_year) {
                $q->where('month', '>=', 10);
                $q->where('year', '=', $previous_year);
            })
            ->orWhere(function ($q) use ($year, $select_month) {
                $q->where('month', '<=', $select_month);
                $q->where('year', '=', $year);
            })
            ->where('district_office_id', $selected_district)
            ->get();

        $fd = collect($fd);

        $data['tax01_estimated_amount_form'] = $fd->sum('tax01_estimated_amount_form');
        $data['tax01_estimated_amount_money'] = $fd->sum('tax01_estimated_amount_money');
        $data['tax01_accept_payment_form'] = $fd->sum('tax01_accept_payment_form');
        $data['tax01_accept_payment_money'] = $fd->sum('tax01_accept_payment_money');
        $data['tax01_accounts_receivable_brought_forward_form'] = $fd->sum('tax01_accounts_receivable_brought_forward_form');
        $data['tax01_accounts_receivable_brought_forward_money'] = $fd->sum('tax01_accounts_receivable_brought_forward_money');
        $data['tax01_accounts_receivable_accept_payment_form'] = $fd->sum('tax01_accounts_receivable_accept_payment_form');
        $data['tax01_accounts_receivable_accept_payment_money'] = $fd->sum('tax01_accounts_receivable_accept_payment_money');
        $data['tax01_accept_payment_monthly_form'] = $fd->sum('tax01_accept_payment_monthly_form');
        $data['tax01_accept_payment_monthly_money'] = $fd->sum('tax01_accept_payment_monthly_money');

        $data['tax02_estimated_amount_form'] = $fd->sum('tax02_estimated_amount_form');
        $data['tax02_estimated_amount_money'] = $fd->sum('tax02_estimated_amount_money');
        $data['tax02_accept_payment_form'] = $fd->sum('tax02_accept_payment_form');
        $data['tax02_accept_payment_money'] = $fd->sum('tax02_accept_payment_money');
        $data['tax02_accounts_receivable_brought_forward_form'] = $fd->sum('tax02_accounts_receivable_brought_forward_form');
        $data['tax02_accounts_receivable_brought_forward_money'] = $fd->sum('tax02_accounts_receivable_brought_forward_money');
        $data['tax02_accounts_receivable_accept_payment_form'] = $fd->sum('tax02_accounts_receivable_accept_payment_form');
        $data['tax02_accounts_receivable_accept_payment_money'] = $fd->sum('tax02_accounts_receivable_accept_payment_money');
        $data['tax02_accept_payment_monthly_form'] = $fd->sum('tax02_accept_payment_monthly_form');
        $data['tax02_accept_payment_monthly_money'] = $fd->sum('tax02_accept_payment_monthly_money');

        $data['tax03_estimated_amount_form'] = $fd->sum('tax03_estimated_amount_form');
        $data['tax03_estimated_amount_money'] = $fd->sum('tax03_estimated_amount_money');
        $data['tax03_accept_payment_form'] = $fd->sum('tax03_accept_payment_form');
        $data['tax03_accept_payment_money'] = $fd->sum('tax03_accept_payment_money');
        $data['tax03_accounts_receivable_brought_forward_form'] = $fd->sum('tax03_accounts_receivable_brought_forward_form');
        $data['tax03_accounts_receivable_brought_forward_money'] = $fd->sum('tax03_accounts_receivable_brought_forward_money');
        $data['tax03_accounts_receivable_accept_payment_form'] = $fd->sum('tax03_accounts_receivable_accept_payment_form');
        $data['tax03_accounts_receivable_accept_payment_money'] = $fd->sum('tax03_accounts_receivable_accept_payment_money');
        $data['tax03_accept_payment_monthly_form'] = $fd->sum('tax03_accept_payment_monthly_form');
        $data['tax03_accept_payment_monthly_money'] = $fd->sum('tax03_accept_payment_monthly_money');

        $data['tax04_estimated_amount_form'] = $fd->sum('tax04_estimated_amount_form');
        $data['tax04_estimated_amount_money'] = $fd->sum('tax04_estimated_amount_money');
        $data['tax04_accept_payment_form'] = $fd->sum('tax04_accept_payment_form');
        $data['tax04_accept_payment_money'] = $fd->sum('tax04_accept_payment_money');
        $data['tax04_accounts_receivable_brought_forward_form'] = $fd->sum('tax04_accounts_receivable_brought_forward_form');
        $data['tax04_accounts_receivable_brought_forward_money'] = $fd->sum('tax04_accounts_receivable_brought_forward_money');
        $data['tax04_accounts_receivable_accept_payment_form'] = $fd->sum('tax04_accounts_receivable_accept_payment_form');
        $data['tax04_accounts_receivable_accept_payment_money'] = $fd->sum('tax04_accounts_receivable_accept_payment_money');
        $data['tax04_accept_payment_monthly_form'] = $fd->sum('tax04_accept_payment_monthly_form');
        $data['tax04_accept_payment_monthly_money'] = $fd->sum('tax04_accept_payment_monthly_money');

        return $data;

    }

    public function exportExcel($data)
    {

        return Excel::download(new \App\Exports\FD0201($data), 'fd02-01.xlsx');
    }

    public function exportPDF($data, $InitiationYearTax)
    {

        $pdf = PDF::loadView('export.fd01', [
            'fd' => $data['fd'],
            'cumulative_year' => $data['cumulative_year'],
            'initiation_year_tax' => $InitiationYearTax,
            'selected' => [
                'selected_month' => $data['selected']['selected_month'],
                'selected_month_short' => $data['selected']['selected_month'] != 0 ? DateList::getMonthShort($data['selected']['selected_month']) : null,
                'selected_year' => $data['selected']['selected_year'],
                'selected_year_short' => Str::substr($data['selected']['selected_year'], -2, 2) ?? null,
                'selected_district' => $data['selected']['selected_district']]
        ])->setPaper(array(0,0,600,800), 'landscape');

        return $pdf->download('fd01.pdf');
    }
}
