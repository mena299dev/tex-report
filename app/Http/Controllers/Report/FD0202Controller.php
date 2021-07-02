<?php

namespace App\Http\Controllers\Report;

use App\Http\Classes\DateList;
use App\Http\Classes\DistrictList;
use App\Http\Classes\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Form\FD0202;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;


class FD0202Controller extends CrudController
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
        $selected_month = $request->input('on_month') ?? Carbon::now()->month;
        $selected_year = $request->input('on_year') ?? Carbon::now()->year;
        $selected_district = $request->input('district') ?? $user->district_code;

        $fd = FD0202::where('year', $selected_year)
            ->where('month', $selected_month)
            ->where('district_office_id', $selected_district)
            ->get();

        $month_list[0] = 'กรุณาเลือกเดือน';
        foreach (DateList::fullMonthList() as $m_key => $m) {
            $month_list[$m_key] = $m;
        }

        $year_list[0] = 'กรุณาเลือกปี';
        foreach (DateList::yearList() as $y_key => $y) {
            $year_list[$y_key] = $y;
        }

        $district_list[0] = 'กรุณาเลือกเลข';
        foreach (DistrictList::districtCode() as $d_key => $d) {
            $district_list[$d_key] = $d;
        }

        $data['title'] = 'รายงาน สนค.02-02';
        $data['district'] = $district_list;
        $data['month_list'] = $month_list;
        $data['year_list'] = $year_list;
        $data['selected'] = [
            "selected_month" => $selected_month != 0 ? DateList::getMonth($selected_month) : null,
            "selected_year" => $selected_year ?? null,
            "selected_district" => $selected_district != 0 ? DistrictList::getDistrictName($selected_district)[$selected_district] : null
        ];
        $data['fd'] = $fd;



        if ($request->input('debug') == 'dev') {
            return $data;
        }

        if ($request->input('btn_type') == 'download') {
            switch ($request->input('download_type')) {
                case "excel" :
                    return self::exportExcel($data);
                default :
                    return self::exportPDF($data);
            }
        }

        return view('report.fd02-02')->with($data);
//        return view('export.fd02-01')->with($data);
    }

    public function exportExcel($data)
    {

        return Excel::download(new \App\Exports\FD0202($data), 'fd02-02.xlsx');
    }

    public function exportPDF($data)
    {
        $pdf = PDF::loadView('export.fd02-02', [
            'fd' => $data['fd'],
            'selected_month' => $data['selected']['selected_month'],
            'selected_year' => $data['selected']['selected_year'],
            'selected_district' => $data['selected']['selected_district'],
        ])->setPaper('a4', 'landscape');;

        return $pdf->download('fd02-02.pdf');
    }
}
