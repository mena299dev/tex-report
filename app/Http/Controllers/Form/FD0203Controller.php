<?php

namespace App\Http\Controllers\Form;

use App\Http\Classes\DateList;
use App\Http\Classes\Redirect;
use App\Models\Form\FD0203;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FD0203Controller extends CrudController
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
        $this->crud->setModel('App\Models\Form\FD0203');
        $this->crud->setEntityNameStrings('เพิ่ม', 'สนค.02-3');
        $this->crud->setRoute('fd-02-3');
        if ($user->district_code != '1000' && $user->district_code != '1402') {
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
                'type' => 'number_fd0203',
            ],
            [
                'name' => 'increment_amount',
                'label' => 'จำนวนเงิน ค่าเพิ่ม',
                'type' => 'number_fd0203',
            ],
            [
                'name' => 'total_amount',
                'label' => 'จำนวนเงิน รวม',
                'type' => 'number_fd0203',
            ],
            [
                'name' => 'receive_number',
                'label' => 'เลขรับที่',
                'type' => 'text',
            ],
            [
                'name' => 'date_of_notice_th',
                'label' => 'วันที่รับใบแจ้ง',
                'type' => 'text',
            ],
            [
                'name' => 'date_of_payment_th',
                'label' => 'วันที่รับชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'remark',
                'label' => 'หมายเหตุ',
                'type' => 'text',
            ],

        ]);

        $user = backpack_user();
        if ($user->district_code == 1000 || $user->district_code == 1402) {
            // district Filter
            $this->crud->addFilter(
                [
                    'name' => 'district',
                    'type' => 'dropdown',
                    'label' => 'เขต',
                ],
                User::all()->pluck('name', 'district_code')->toArray(),
                function ($value) {
                    $this->crud->addClause('where', 'district_office_id', $value);
                }
            );
        }

        // Month
        $this->crud->addFilter(
            [
                'name' => 'on_month',
                'type' => 'dropdown',
                'label' => 'เดือน',
            ],
            DateList::fullMonthList(),
            function ($value) {
                $this->crud->addClause('where', 'month', $value);
            }
        );

        // Year
        $this->crud->addFilter(
            [
                'name' => 'on_year',
                'type' => 'dropdown',
                'label' => 'ปี',
            ],
            DateList::yearList(),
            function ($value) {
                $this->crud->addClause('where', 'year', $value);
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->addFromFD0203Fields();
//        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addFromFD0203Fields();
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
        $fd = new FD0203();
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
        $fd->receive_number = $request->input('receive_number');
        $fd->date_of_notice_str = $request->input('date_of_notice_str');
        $fd->date_of_payment_str = $request->input('date_of_payment_str');
        $fd->remark = $request->input('remark');
        $fd->created_at = Carbon::now();
        $fd->updated_at = Carbon::now();
        $fd->save();


        return \redirect(Redirect::redirect('save_and_back',null,'fd-02-3'));
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = backpack_user();
        $fd = FD0203::whereId($id)->first();
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
        $fd->receive_number = $request->input('receive_number');
        $fd->date_of_notice_str = $request->input('date_of_notice_str');
        $fd->date_of_payment_str = $request->input('date_of_payment_str');
        $fd->remark = $request->input('remark');
        $fd->created_at = Carbon::now();
        $fd->updated_at = Carbon::now();
        $fd->save();


        return \redirect(Redirect::redirect($request->input('save_action'),$id,'fd-02-3'));
//        $this->crud->setRequest($this->crud->validateRequest());
//        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
//        $this->crud->unsetValidation(); // validation has already been run

//        return $this->traitUpdate();
    }




    protected function addFromFD0203Fields()
    {
        $this->crud->addFields([
            [
                'name' => 'on_month',
                'label' => 'ประจำเดือน',
                'type' => 'select2_from_arrayFD0203',
                'options' => DateList::fullMonthList(),
                'allows_null' => false,
                'column_name' => 'month',
                'default' => Carbon::now()->format('m') - 1
            ],
            [
                'name' => 'on_year',
                'label' => 'ประจำปี',
                'type' => 'select2_from_arrayFD0203',
                'options' => DateList::yearList(),
                'column_name' => 'year',
                'allows_null' => false,
                'default' => Carbon::now()->addYear(543)->year
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
                'type' => 'number_fd0203',
                'default' => 0
            ],
            [
                'name' => 'increment_amount',
                'label' => 'จำนวนเงิน ค่าเพิ่ม',
                'type' => 'number_fd0203',
                'default' => 0
            ],
            [
                'name' => 'total_amount',
                'label' => 'จำนวนเงิน รวม',
                'type' => 'sum_total_fd0203',
                'attributes' => [
                    'readonly' => 'readonly'
                ],
                'formula' => true
            ],
            [
                'name' => 'receive_number',
                'label' => 'เลขรับที่',
                'type' => 'text',
            ],
            [
                'name' => 'date_of_notice_str',
                'label' => 'วันที่รับใบแจ้ง',
                'type' => 'text',
            ],
            [
                'name' => 'date_of_payment_str',
                'label' => 'วันที่รับชำระ',
                'type' => 'text',
            ],
            [
                'name' => 'remark',
                'label' => 'หมายเหตุ',
                'type' => 'textarea',
            ]
        ]);
    }
}
