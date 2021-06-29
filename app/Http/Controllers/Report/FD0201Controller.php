<?php

namespace App\Http\Controllers\Report;

use App\Http\Classes\DateList;
use App\Http\Classes\DistrictList;
use App\Http\Classes\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Form\FD0201;
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


class FD0201Controller extends CrudController
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

        $fd = FD0201::where('year', $selected_year)
            ->where('month', $selected_month)
            ->where('district_office_id', $selected_district)
            ->get();

        $data['title'] = 'title FD0201';
        $data['district'] = DistrictList::districtCode();
        $data['month_list'] = DateList::fullMonthList();
        $data['year_list'] = DateList::yearList();
        $data['selected'] = [
            "selected_month" => DateList::getMonth($selected_month),
            "selected_year" => $selected_year,
            "selected_district" => DistrictList::getDistrictName($selected_district)[$selected_district]
        ];
        $data['fd'] = $fd;

        if ($request->input('debug') == 'dev') {
            return $data;
        }

        if ($request->input('btn_type') == 'download') {
            switch ($request->input('download_type')) {
                case "excel" :
                    return self::exportExcel($data);
                    break;

                default :
                    return self::exportPDF($data);
                    break;
            }


        }

        return view('report.fd02-01')->with($data);
//        return view('export.fd02-01')->with($data);
    }

    public function exportExcel($data)
    {

        return Excel::download(new \App\Exports\FD0201($data), 'fd02-01.xlsx');
//        return Excel::download(new \App\Exports\FD0201($data), 'fd02-01.pdf');
    }

    public function exportPDF($data)
    {
        $user = backpack_user();
        $selected_month = request('on_month') ?? Carbon::now()->month;
        $selected_year = request('on_year') ?? Carbon::now()->year;
        $selected_district = request('district') ?? $user->district_code;

        $fd = \App\Models\Form\FD0201::where('year', $selected_year)
            ->where('month', $selected_month)
            ->where('district_office_id', $selected_district)
            ->get();

        $pdf = PDF::loadView('export.fd02-01', [
            'fd' => $fd,
            'selected_month' => DateList::getMonth($selected_month),
            'selected_year' => $selected_year,
            'selected_district' => DistrictList::getDistrictName($selected_district)[$selected_district],
        ])->setPaper('a4', 'landscape');;
        return  $pdf->download('fd02-01.pdf');
//        return Excel::download(new \App\Exports\FD0201($data), 'fd02-01.pdf');
    }
}
