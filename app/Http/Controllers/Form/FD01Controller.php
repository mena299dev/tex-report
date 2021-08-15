<?php

namespace App\Http\Controllers\Form;

use App\Http\Classes\DateList;
use App\Http\Classes\Redirect;
use App\Models\Form\FD01;
use App\Models\Form\FD0201;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function setup()
    {
        $user = backpack_user();
        $this->crud->setModel('App\Models\Form\FD01');
        $this->crud->setEntityNameStrings('เพิ่ม', 'สนค.01');
        $this->crud->setRoute('fd-01');
        if ($user->district_code != '1000' && $user->district_code != '1402') {
            $this->crud->addClause('where', 'district_office_id', '=', $user->district_code);
        }

    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'district_office_id',
                'label' => 'รหัสแขวง',
                'type' => 'text',
            ],
            [
                'name' => 'on_month',
                'label' => 'เดือน',
                'type' => 'text',
            ],
            [
                'name' => 'on_year',
                'label' => 'ปี',
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
        $this->crud->addFields(static::addForm());
        $this->crud->addFields(static::addFormTax01());
        $this->crud->addFields(static::addFormTax02());
        $this->crud->addFields(static::addFormTax03());
        $this->crud->addFields(static::addFormTax04());
//        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->setupCreateOperation();
//        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $json = self::prepareJson($request);
        $user = backpack_user();

        $fd = new FD01();
        $fd->district_office_name = $request->input('district') ?? $user->username;
        $fd->district_office_id = $user->district_code;
        $fd->month = $request->input('on_month');
        $fd->year = $request->input('on_year');
        $fd->json = json_encode($json);
        $fd->created_at = Carbon::now();
        $fd->updated_at = Carbon::now();
        $fd->save();

        return \redirect(Redirect::redirect('save_and_back', null, 'fd-01'));
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = backpack_user();
        $fd = FD01::whereId($id)->first();
        if (!$fd) {
            return 'error id not found';
        }
        $json = self::prepareJson($request);

        $fd->district_office_name = $request->input('district') ?? $user->username;
        $fd->district_office_id = $user->district_code;
        $fd->month = $request->input('on_month');
        $fd->year = $request->input('on_year');
        $fd->json = json_encode($json);
        $fd->updated_at = Carbon::now();
        $fd->save();

        return \redirect(Redirect::redirect('save_and_back', $id, 'fd-01'));
    }

    private static function prepareJson($request)
    {
        $json_data = [];
        $json_data['tax01'] = [
            'code' => 'tax01',
            'tax01_estimated_amount_form' => $request->input('tax01_estimated_amount_form') ?? 0,
            'tax01_estimated_amount_money' => $request->input('tax01_estimated_amount_money') ?? 0,
            'tax01_accept_payment_form' => $request->input('tax01_accept_payment_form') ?? 0,
            'tax01_accept_payment_money' => $request->input('tax01_accept_payment_money') ?? 0,
            'tax01_accounts_receivable_brought_forward_form' => $request->input('tax01_accounts_receivable_brought_forward_form') ?? 0,
            'tax01_accounts_receivable_brought_forward_money' => $request->input('tax01_accounts_receivable_brought_forward_money') ?? 0,
            'tax01_accounts_receivable_accept_payment_form' => $request->input('tax01_accounts_receivable_accept_payment_form') ?? 0,
            'tax01_accounts_receivable_accept_payment_money' => $request->input('tax01_accounts_receivable_accept_payment_money') ?? 0,
            'tax01_accept_payment_monthly_form' => $request->input('tax01_accept_payment_monthly_form') ?? 0,
            'tax01_accept_payment_monthly_money' => $request->input('tax01_accept_payment_monthly_money') ?? 0,
        ];

        $json_data['tax02'] = [
            'code' => 'tax02',
            'tax02_estimated_amount_form' => $request->input('tax02_estimated_amount_form') ?? 0,
            'tax02_estimated_amount_money' => $request->input('tax02_estimated_amount_money') ?? 0,
            'tax02_accept_payment_form' => $request->input('tax02_accept_payment_form') ?? 0,
            'tax02_accept_payment_money' => $request->input('tax02_accept_payment_money') ?? 0,
            'tax02_accounts_receivable_brought_forward_form' => $request->input('tax02_accounts_receivable_brought_forward_form') ?? 0,
            'tax02_accounts_receivable_brought_forward_money' => $request->input('tax02_accounts_receivable_brought_forward_money') ?? 0,
            'tax02_accounts_receivable_accept_payment_form' => $request->input('tax02_accounts_receivable_accept_payment_form') ?? 0,
            'tax02_accounts_receivable_accept_payment_money' => $request->input('tax02_accounts_receivable_accept_payment_money') ?? 0,
            'tax02_accept_payment_monthly_form' => $request->input('tax02_accept_payment_monthly_form') ?? 0,
            'tax02_accept_payment_monthly_money' => $request->input('tax02_accept_payment_monthly_money') ?? 0,
        ];

        $json_data['tax03'] = [
            'code' => 'tax03',
            'tax03_estimated_amount_form' => $request->input('tax03_estimated_amount_form') ?? 0,
            'tax03_estimated_amount_money' => $request->input('tax03_estimated_amount_money') ?? 0,
            'tax03_accept_payment_form' => $request->input('tax03_accept_payment_form') ?? 0,
            'tax03_accept_payment_money' => $request->input('tax03_accept_payment_money') ?? 0,
            'tax03_accounts_receivable_brought_forward_form' => $request->input('tax03_accounts_receivable_brought_forward_form') ?? 0,
            'tax03_accounts_receivable_brought_forward_money' => $request->input('tax03_accounts_receivable_brought_forward_money') ?? 0,
            'tax03_accounts_receivable_accept_payment_form' => $request->input('tax03_accounts_receivable_accept_payment_form') ?? 0,
            'tax03_accounts_receivable_accept_payment_money' => $request->input('tax03_accounts_receivable_accept_payment_money') ?? 0,
            'tax03_accept_payment_monthly_form' => $request->input('tax03_accept_payment_monthly_form') ?? 0,
            'tax03_accept_payment_monthly_money' => $request->input('tax03_accept_payment_monthly_money') ?? 0,
        ];

        $json_data['tax04'] = [
            'code' => 'tax04',
            'tax04_estimated_amount_form' => $request->input('tax04_estimated_amount_form') ?? 0,
            'tax04_estimated_amount_money' => $request->input('tax04_estimated_amount_money') ?? 0,
            'tax04_accept_payment_form' => $request->input('tax04_accept_payment_form') ?? 0,
            'tax04_accept_payment_money' => $request->input('tax04_accept_payment_money') ?? 0,
            'tax04_accounts_receivable_brought_forward_form' => $request->input('tax04_accounts_receivable_brought_forward_form') ?? 0,
            'tax04_accounts_receivable_brought_forward_money' => $request->input('tax04_accounts_receivable_brought_forward_money') ?? 0,
            'tax04_accounts_receivable_accept_payment_form' => $request->input('tax04_accounts_receivable_accept_payment_form') ?? 0,
            'tax04_accounts_receivable_accept_payment_money' => $request->input('tax04_accounts_receivable_accept_payment_money') ?? 0,
            'tax04_accept_payment_monthly_form' => $request->input('tax04_accept_payment_monthly_form') ?? 0,
            'tax04_accept_payment_monthly_money' => $request->input('tax04_accept_payment_monthly_money') ?? 0,
        ];


        return $json_data;
    }

    protected static function addForm()
    {
        return [
            [
                'name' => 'on_month',
                'label' => 'ประจำเดือน',
                'type' => 'select2_from_arrayFD01',
                'options' => DateList::fullMonthList(),
                'allows_null' => false,
                'column_name' => 'month',
                'default' => Carbon::now()->format('m') - 1,
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'on_year',
                'label' => 'ประจำปี',
                'type' => 'select2_from_arrayFD01',
                'options' => DateList::yearList(),
                'column_name' => 'year',
                'allows_null' => false,
                'default' => Carbon::now()->addYear(543)->year,
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
        ];
    }

    protected static function addFormTax01()
    { //ภาษีโรงเรือนและที่ดิน
        return [
            [
                'name' => 'tax01_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีโรงเรือนและที่ดิน <<',
            ],
            [
                'name' => 'tax01_estimated_amount_form',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax01_estimated_amount_money',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],


            [
                'name' => 'tax01_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax01_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax01_accounts_receivable_brought_forward_form',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax01_accounts_receivable_brought_forward_money',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax01_accounts_receivable_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงิน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax01_accounts_receivable_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงิน(เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax01_accept_payment_monthly_form',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax01_accept_payment_monthly_money',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
        ];
    }

    protected static function addFormTax02()
    { //ภาษีบำรุ้งท้องที่
        return [
            [
                'name' => 'tax02_label_header_1',
                'type' => 'label_header',
                'label' => '',
            ],
            [
                'name' => 'tax02_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีบำรุ้งท้องที่ <<',
            ],
            [
                'name' => 'tax02_estimated_amount_form',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax02_estimated_amount_money',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],


            [
                'name' => 'tax02_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax02_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax02_accounts_receivable_brought_forward_form',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax02_accounts_receivable_brought_forward_money',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax02_accounts_receivable_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงิน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax02_accounts_receivable_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงิน(เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax02_accept_payment_monthly_form',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax02_accept_payment_monthly_money',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
        ];
    }

    protected static function addFormTax03()
    { //ภาษีป้าย
        return [
            [
                'name' => 'tax03_label_header_1',
                'type' => 'label_header',
                'label' => '',
            ],
            [
                'name' => 'tax03_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีป้าย <<',
            ],
            [
                'name' => 'tax03_estimated_amount_form',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax03_estimated_amount_money',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],


            [
                'name' => 'tax03_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax03_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax03_accounts_receivable_brought_forward_form',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax03_accounts_receivable_brought_forward_money',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax03_accounts_receivable_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงิน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax03_accounts_receivable_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงิน(เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax03_accept_payment_monthly_form',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax03_accept_payment_monthly_money',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
        ];
    }


    protected static function addFormTax04()
    { //ภาษีที่ดินและสิ่งปลูกสร้าง
        return [
            [
                'name' => 'tax04_label_header_1',
                'type' => 'label_header',
                'label' => '',
            ],
            [
                'name' => 'tax04_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีที่ดินและสิ่งปลูกสร้าง <<',
            ],
            [
                'name' => 'tax04_estimated_amount_form',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax04_estimated_amount_money',
                'type' => 'number',
                'label' => 'ยอดประเมินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],


            [
                'name' => 'tax04_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax04_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงินเดือนที่รายงาน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax04_accounts_receivable_brought_forward_form',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax04_accounts_receivable_brought_forward_money',
                'type' => 'number',
                'label' => 'ลูกหนี้ค้างชำระคงเหลือยกมา (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax04_accounts_receivable_accept_payment_form',
                'type' => 'number',
                'label' => 'รับชำระเงิน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax04_accounts_receivable_accept_payment_money',
                'type' => 'number',
                'label' => 'รับชำระเงิน(เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],

            [
                'name' => 'tax04_accept_payment_monthly_form',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (ราย)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax04_accept_payment_monthly_money',
                'type' => 'number',
                'label' => 'รับชำระประจำเดือน (เงิน)',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
        ];
    }
}
