<?php

namespace App\Http\Controllers\Form;

use App\Http\Classes\Redirect;
use App\Models\Form\FD0201;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function setup()
    {
        $user = backpack_user();
        $this->crud->setModel('App\Models\Form\FD0201');
        $this->crud->setEntityNameStrings('เพิ่ม', 'สนค.02-1');
        $this->crud->setRoute('fd-02-1');
        if($user->district_code != '1000'){
            $this->crud->addClause('where', 'district_office_id', '=', $user->district_code);
        }

    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'sequence',
                'label' => 'ลำดับ',
                'type' => 'text',
            ],
            [
                'name' => 'district_office_id',
                'label' => 'รหัสแขวง',
                'type' => 'text',
            ],
            [
                'name' => 'district',
                'label' => 'แขวง',
                'type' => 'text',
            ],
            [
                'name' => 'defaulter_name',
                'label' => 'รายชื่อผู้ค้างชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'defaulter_year',
                'label' => 'ปีที่ค้างชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'tax_amount',
                'label' => 'จำนวนเงิน ค่าภาษี',
                'type' => 'number_fd0201',
            ],
            [
                'name' => 'increment_amount',
                'label' => 'จำนวนเงิน ค่าเพิ่ม',
                'type' => 'number_fd0201',
            ],
            [
                'name' => 'total_amount',
                'label' => 'จำนวนเงิน รวม',
                'type' => 'number_fd0201',
            ],
            [
                'name' => 'date_of_notice',
                'label' => 'วันที่รับใบแจ้ง',
                'type' => 'text',
            ],
            [
                'name' => 'date_of_payment',
                'label' => 'วันที่รับชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'remark',
                'label' => 'หมายเหตุ',
                'type' => 'text',
            ],

        ]);

        // district Filter
        $this->crud->addFilter(
            [
                'name' => 'district',
                'type' => 'dropdown',
                'label' => 'เขต',
            ],
            User::all()->pluck('district_code', 'district_code')->toArray(),
            function ($value) {
                $this->crud->addClause('where', 'district_office_id', $value);
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->addFromFD0201Fields();
//        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addFromFD0201Fields();
//        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = backpack_user();
        $fd = new FD0201();
        $fd->sequence = $request->input('sequence');
        $fd->district_office_name = $user->username;
        $fd->district_office_id = $user->district_code;
        $fd->month = $request->input('on_month');
        $fd->year = $request->input('on_year');
        $fd->district = $request->input('district');
        $fd->defaulter_name = $request->input('defaulter_name');
        $fd->defaulter_year = $request->input('defaulter_year');
        $fd->tax_amount = $request->input('tax_amount');
        $fd->increment_amount = $request->input('increment_amount');
        $fd->date_of_notice = $request->input('date_of_notice');
        $fd->date_of_payment = $request->input('date_of_payment');
        $fd->remark = $request->input('remark');
        $fd->created_at = Carbon::now();
        $fd->updated_at = Carbon::now();
        $fd->save();


        return \redirect(Redirect::redirect($request->input('save_action'),null,'fd-02-1'));
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$id)
    {
        $user = backpack_user();
        $fd = FD0201::whereId($id)->first();
        if(!$fd){
            return 'error id not found';
        }
        $fd->sequence = $request->input('sequence');
        $fd->district_office_name = $user->username;
        $fd->district_office_id = $user->district_code;
        $fd->month = $request->input('on_month');
        $fd->year = $request->input('on_year');
        $fd->district = $request->input('district');
        $fd->defaulter_name = $request->input('defaulter_name');
        $fd->defaulter_year = $request->input('defaulter_year');
        $fd->tax_amount = $request->input('tax_amount');
        $fd->increment_amount = $request->input('increment_amount');
        $fd->date_of_notice = $request->input('date_of_notice');
        $fd->date_of_payment = $request->input('date_of_payment');
        $fd->remark = $request->input('remark');
        $fd->created_at = Carbon::now();
        $fd->updated_at = Carbon::now();
        $fd->save();

        return \redirect(Redirect::redirect($request->input('save_action'),$id,'fd-02-1'));
    }


    protected function addFromFD0201Fields()
    {
        $this->crud->addFields([
            [
                'name' => 'on_month',
                'label' => 'ประจำเดือน',
                'type' => 'select2_from_array',
                'options' => ["มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                'allows_null' => false,
                'default' => Carbon::now()->format('m') - 1
            ],
            [
                'name' => 'on_year',
                'label' => 'ประจำปี',
                'type' => 'select2_from_array',
                'options' => [
                    Carbon::now()->addYear("-2")->year,
                    Carbon::now()->addYear("-1")->year,
                    Carbon::now()->year,
                    Carbon::now()->addYear("1")->year,
                    Carbon::now()->addYear("2")->year,
                ],
                'allows_null' => false,
                'default' => 2
            ],
            [
                'name' => 'sequence',
                'label' => 'ลำดับ',
                'type' => 'text',
            ],
            [
                'name' => 'district',
                'label' => 'แขวง',
                'type' => 'text',
            ],
            [
                'name' => 'defaulter_name',
                'label' => 'รายชื่อผู้ค้างชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'defaulter_year',
                'label' => 'ปีที่ค้างชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'tax_amount',
                'label' => 'จำนวนเงิน ค่าภาษี',
                'type' => 'number_fd0201',
                'default' => 0
            ],
            [
                'name' => 'increment_amount',
                'label' => 'จำนวนเงิน ค่าเพิ่ม',
                'type' => 'number_fd0201',
                'default' => 0
            ],
            [
                'name' => 'total_amount',
                'label' => 'จำนวนเงิน รวม',
                'type' => 'sum_total_fd0201',
                'attributes' => [
                    'readonly' => 'readonly'
                ],
                'formula' => true
            ],
            [
                'name' => 'date_of_notice',
                'label' => 'วันที่รับใบแจ้ง',
                'type' => 'date',

                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format' => 'dd-mm-yyyy',
                    'language' => 'th'
                ],
            ],
            [
                'name' => 'date_of_payment',
                'label' => 'วันที่รับชำระ',
                'type' => 'date',

                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format' => 'dd-mm-yyyy',
                    'language' => 'th'
                ],
            ],
            [
                'name' => 'remark',
                'label' => 'หมายเหตุ',
                'type' => 'textarea',
            ]
        ]);
    }
}
