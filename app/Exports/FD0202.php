<?php

namespace App\Exports;

use App\Http\Classes\DateList;
use App\Http\Classes\DistrictList;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FD0202 implements FromView, WithColumnWidths, WithStyles, WithEvents
{

    public function view(): View
    {
        $user = backpack_user();
        $selected_month = request('on_month') ?? Carbon::now()->month;
        $selected_year = request('on_year') ?? Carbon::now()->year;
        $selected_district = request('district') ?? $user->district_code;

        $fd = \App\Models\Form\FD0201::where('year', $selected_year)
            ->where('month', $selected_month)
            ->where('district_office_id', $selected_district)
            ->get();

        return view('export.fd02-01', [
            'fd' => $fd,
            'selected_month' => DateList::getMonth($selected_month),
            'selected_year' => $selected_year,
            'selected_district' => DistrictList::getDistrictName($selected_district)[$selected_district],
        ]);
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16],'name' => 'THSarabun'],
        ];

//        $sheet->setName('THSarabun');
//        $sheet->getDefaultRowDimension()->setRowHeight(22);//Set line height
//        $sheet->getStyle('A1:Z' . 1)->getAlignment()->setVertical('center');//Vertical center
//        $sheet->getStyle('F1:K' . 2)->applyFromArray(['alignment' => ['horizontal' => 'center']]);//Set horizontal center
//        $sheet->getStyle('A1:Z1')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => '0072ff']]]);//Font setting
//        $cell = ['A', 'B', 'C', 'D', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];//The cells to be merged
//        //$sheet->mergeCells('A18:A22'); //Merge cells
//        foreach ($cell as $item) {
//            $start = 2;
//            foreach ([] as $key => $value) {
//                $end = $start + $value - 1;
//                $sheet->mergeCells($item . $start . ':' . $item . $end); //Merge Cells
//                $start = $end + 1;
//            }
//        }
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setName('THSarabun');

            },

        ];

    }

    public static function afterSheet(AfterSheet $event)
    {
        // Create Style Arrays
        $default_font_style = [
            'font' => ['name' => 'THSarabun', 'size' => 10]
        ];

        $strikethrough = [
            'font' => ['strikethrough' => true],
        ];

        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();

        // Apply Style Arrays
        $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);

        // strikethrough group of cells (A10 to B12)
        $active_sheet->getStyle('A10:B12')->applyFromArray($strikethrough);
        // or
        $active_sheet->getStyle('A10:B12')->getFont()->setStrikethrough(true);

        // single cell
        $active_sheet->getStyle('A13')->getFont()->setStrikethrough(true);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 45,
        ];
    }
}
