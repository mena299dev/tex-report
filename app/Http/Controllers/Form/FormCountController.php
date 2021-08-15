<?php

namespace App\Http\Controllers\Form;

use App\Http\Classes\DateList;
use App\Http\Classes\Redirect;
use App\Http\Classes\TaxList;
use App\Models\Form\FD0204;
use App\Models\Form\FormCount;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FormCountController extends CrudController
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
        $this->crud->setModel('App\Models\Form\FormCount');
        $this->crud->setEntityNameStrings('เพิ่ม', 'จำนวนแบบยื่น/จำนวนราย');
        $this->crud->setRoute('form-count');
        if ($user->district_code != '1000' && $user->district_code != '1402') {
            $this->crud->addClause('where', 'district_office_id', '=', $user->district_code);
        }

    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'district_office_name',
                'label' => 'เขต',
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
//        $this->addFromFromCountFields();
//        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->setupCreateOperation();
//        $this->addFromFD0204Fields();
//        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $tax_list = TaxList::fromCountTaxList();

        $json_data['tax01']['type'] =  'tax01';
        $json_data['tax01']['name'] =  $tax_list['tax01'] ?? 'tax01_name not found';
        $json_data['tax01']['tax01_serving_form'] =  $request->input('tax01_serving_form') ?? 0;
        $json_data['tax01']['tax01_code_house'] =  $request->input('tax01_code_house') ?? 0;

        $json_data['tax02']['type'] =  'tax02';
        $json_data['tax02']['name'] =  $tax_list['tax02'] ?? 'tax02_name not found';
        $json_data['tax02']['tax02_serving_form'] =  $request->input('tax02_serving_form') ?? 0;
        $json_data['tax02']['tax02_count_land'] =  $request->input('tax02_count_land') ?? 0;

        $json_data['tax03']['type'] =  'tax03';
        $json_data['tax03']['name'] =  $tax_list['tax03'] ?? 'tax03_name not found';
        $json_data['tax03']['tax03_serving_form'] =  $request->input('tax03_serving_form') ?? 0;
        $json_data['tax03']['tax03_count_tablet'] =  $request->input('tax03_count_tablet') ?? 0;

        $json_data['tax04']['type'] =  'tax04';
        $json_data['tax04']['name'] =  $tax_list['tax04'] ?? 'tax03_name not found';
        $json_data['tax04']['tax04_count_land'] =  $request->input('tax04_count_land') ?? 0;
        $json_data['tax04']['tax04_code_house'] =  $request->input('tax04_code_house') ?? 0;
        $json_data['tax04']['tax04_tax_customer'] =  $request->input('tax04_tax_customer') ?? 0;

        $user = backpack_user();
        $fc = new FormCount();
        $fc->district_office_name = $user->username;
        $fc->district_office_id = $user->district_code;
        $fc->month = $request->input('on_month');
        $fc->year = $request->input('on_year');
        $fc->year = $request->input('on_year');
        $fc->json = json_encode($json_data) ?? null;
        $fc->created_at = Carbon::now();
        $fc->updated_at = Carbon::now();
        $fc->save();


        return \redirect(Redirect::redirect($request->input('save_action'), null, 'form-count'));
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $fc = FormCount::whereId($id)->first();
        if (!$fc) {
            return 'error id not found';
        }
        $tax_list = TaxList::fromCountTaxList();

        $json_data['tax01']['type'] =  'tax01';
        $json_data['tax01']['name'] =  $tax_list['tax01'] ?? 'tax01_name not found';
        $json_data['tax01']['tax01_serving_form'] =  $request->input('tax01_serving_form') ?? 0;
        $json_data['tax01']['tax01_code_house'] =  $request->input('tax01_code_house') ?? 0;

        $json_data['tax02']['type'] =  'tax02';
        $json_data['tax02']['name'] =  $tax_list['tax02'] ?? 'tax02_name not found';
        $json_data['tax02']['tax02_serving_form'] =  $request->input('tax02_serving_form') ?? 0;
        $json_data['tax02']['tax02_count_land'] =  $request->input('tax02_count_land') ?? 0;

        $json_data['tax03']['type'] =  'tax03';
        $json_data['tax03']['name'] =  $tax_list['tax03'] ?? 'tax03_name not found';
        $json_data['tax03']['tax03_serving_form'] =  $request->input('tax03_serving_form') ?? 0;
        $json_data['tax03']['tax03_count_tablet'] =  $request->input('tax03_count_tablet') ?? 0;

        $json_data['tax04']['type'] =  'tax04';
        $json_data['tax04']['name'] =  $tax_list['tax04'] ?? 'tax03_name not found';
        $json_data['tax04']['tax04_count_land'] =  $request->input('tax04_count_land') ?? 0;
        $json_data['tax04']['tax04_code_house'] =  $request->input('tax04_code_house') ?? 0;
        $json_data['tax04']['tax04_tax_customer'] =  $request->input('tax04_tax_customer') ?? 0;

        $user = backpack_user();
        $fc->district_office_name = $user->username;
        $fc->district_office_id = $user->district_code;
        $fc->month = $request->input('on_month');
        $fc->year = $request->input('on_year');
        $fc->year = $request->input('on_year');
        $fc->json = json_encode($json_data) ?? null;
        $fc->created_at = Carbon::now();
        $fc->updated_at = Carbon::now();
        $fc->save();


        return \redirect(Redirect::redirect($request->input('save_action'), $id, 'form-count'));
//        $this->crud->setRequest($this->crud->validateRequest());
//        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
//        $this->crud->unsetValidation(); // validation has already been run

//        return $this->traitUpdate();
    }

    protected static function addForm()
    {
        return [
            [
                'name' => 'on_month',
                'label' => 'ประจำเดือน',
                'type' => 'select2_from_arrayFormCount',
                'options' => DateList::fullMonthList(),
                'allows_null' => false,
                'column_name' => 'month',
                'default' => Carbon::now()->format('m') - 1,
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'on_year',
                'label' => 'ประจำปี',
                'type' => 'select2_from_arrayFormCount',
                'options' => DateList::yearList(),
                'column_name' => 'year',
                'allows_null' => false,
                'default' => Carbon::now()->addYear(543)->year,
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
        ];
    }

    protected static function addFormTax01()
    {
        return [
            [
                'name' => 'tax01_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีโรงเรือนและที่ดิน <<',
            ],
            [
                'name' => 'tax01_serving_form',
                'type' => 'number',
                'label' => 'จำนวนแบบยื่น (ราย)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'tax01_code_house',
                'type' => 'number',
                'label' => 'จำนวนรหัสประจำบ้าน (หลัง)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
        ];
    }

    protected static function addFormTax02()
    {
        return [
            [
                'name' => 'tax02_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีบำรุ้งท้องที่ <<',
            ],
            [
                'name' => 'tax02_serving_form',
                'type' => 'number',
                'label' => 'จำนวนแบบยื่น (ราย)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'tax02_count_land',
                'type' => 'number',
                'label' => 'จำนวนแปลง (แปลง)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
        ];
    }

    protected static function addFormTax03()
    {
        return [
            [
                'name' => 'tax03_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีป้าย <<',
            ],
            [
                'name' => 'tax03_serving_form',
                'type' => 'number',
                'label' => 'จำนวนแบบยื่น (ราย)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'tax03_count_tablet',
                'type' => 'number',
                'label' => 'จำนวนป้าย (ป้าย)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
        ];
    }

    protected static function addFormTax04()
    {
        return [
            [
                'name' => 'tax04_label_header',
                'type' => 'label_header',
                'label' => '>> ภาษีที่ดินและสิ่งปลูกสร้าง <<',
            ],
            [
                'name' => 'tax04_count_land',
                'type' => 'number',
                'label' => 'จำนวนแปลงที่ดิน (แปลง)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'tax04_code_house',
                'type' => 'number',
                'label' => 'จำนวนรหัสประจำบ้าน (หลัง)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'tax04_tax_customer',
                'type' => 'number',
                'label' => 'จำนวนรายผู้เสียภาษี (ราย)',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],

        ];
    }

}
