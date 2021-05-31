<?php

namespace App\Http\Controllers\Form;

use App\Models\Form\FD0201;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
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
        $this->crud->setModel('App\Models\Form\FD0201');
        $this->crud->setEntityNameStrings('เพิ่ม', 'สนค.02-1');
        $this->crud->setRoute('fd-02-1');
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
                'type' => 'number',
            ],
            [
                'name' => 'increment_amount',
                'label' => 'จำนวนเงิน ค่าเพิ่ม',
                'type' => 'number',
            ],
            [
                'name' => 'total_amount',
                'label' => 'จำนวนเงิน รวม',
                'type' => 'number',
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
            [ // n-n relationship (with pivot table)
                'label' => trans('backpack::permissionmanager.roles'), // Table column heading
                'type' => 'select_multiple',
                'name' => 'roles', // the method that defines the relationship in your Model
                'entity' => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => config('permission.models.role'), // foreign key model
            ]
        ]);

        // Role Filter
        $this->crud->addFilter(
            [
                'name' => 'role',
                'type' => 'dropdown',
                'label' => trans('backpack::permissionmanager.role'),
            ],
            config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                    $query->where('role_id', '=', $value);
                });
            }
        );

        // Extra Permission Filter
        $this->crud->addFilter(
            [
                'name' => 'permissions',
                'type' => 'select2',
                'label' => trans('backpack::permissionmanager.extra_permissions'),
            ],
            config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                    $query->where('permission_id', '=', $value);
                });
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
        return $user = backpack_user();
        $fd = new FD0201();
        $fd->sequence = $request->input('sequence');
        $fd->district_office_name = $user->username;
        $fd->district_office_id = $user->district_code;
        $fd->month = $request->input('on_month');
        $fd->year = $request->input('on_year');
        $fd->district = $request->input('sequence');
        $fd->defaulter_name = $request->input('sequence');
        $fd->defaulter_year = $request->input('sequence');
        $fd->tax_amount = $request->input('sequence');
        $fd->increment_amount = $request->input('sequence');
        $fd->date_of_notice = $request->input('sequence');
        $fd->date_of_payment = $request->input('sequence');
        $fd->remark = $request->input('sequence');
        $fd->created_at = Carbon::now();
        $fd->updated_at = Carbon::now();


        return redirect('fd-02-1');
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
//        $this->crud->setRequest($this->crud->validateRequest());
//        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }


    protected function addFromFD0201Fields()
    {
        $this->crud->addFields([
            [
                'name' => 'on_month',
                'label' => 'ประจำเดือน',
                'type' => 'select2_from_array',
                'options' => ["มกราคม","กุมภาพันธ์ ","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
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
                'type' => 'number',
            ],
            [
                'name' => 'increment_amount',
                'label' => 'จำนวนเงิน ค่าเพิ่ม',
                'type' => 'number',
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
