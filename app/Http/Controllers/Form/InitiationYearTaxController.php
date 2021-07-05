<?php

namespace App\Http\Controllers\Form;

use App\Http\Classes\DateList;
use App\Http\Classes\DistrictList;
use App\Http\Classes\Redirect;
use App\Models\Form\FD0201;
use App\Models\Form\InitiationYearTax;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InitiationYearTaxController extends CrudController
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
        $this->crud->setModel('App\Models\Form\InitiationYearTax');
        $this->crud->setEntityNameStrings('เพิ่ม', 'ประมาณการรายรับประจำปีงบประมาณ');
        $this->crud->setRoute('initiation-year-tax');
        if ($user->district_code != '1000') {
            $this->crud->addClause('where', 'district_office_id', '=', $user->district_code);
        }

    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'district_office_id',
                'label' => 'รหัสเขต',
                'type' => 'text',
            ],
            [
                'name' => 'district_office_name',
                'label' => 'เขต',
                'type' => 'text',
            ],
            [
                'name' => 'year_of_money',
                'label' => 'ปีงบประมาณ',
                'type' => 'text',
            ],
            [
                'name' => 'tax01',
                'label' => 'ภาษีโรงเรือนและที่ดิน',
                'type' => 'text',
            ],
            [
                'name' => 'tax02',
                'label' => 'ภาษีบำรุ้งท้องที่',
                'type' => 'text',
            ],
            [
                'name' => 'tax03',
                'label' => 'ภาษีป้าย',
                'type' => 'text',
            ],
            [
                'name' => 'tax04',
                'label' => 'ภาษีที่ดินและสิ่งปลูกสร้าง',
                'type' => 'text',
            ],

        ]);

        $user = backpack_user();
        if ($user->district_code == 1000 || $user->district_code == 1402) {
            // district Filter
            $this->crud->addFilter(
                [
                    'name' => 'district',
                    'type' => 'select2',
                    'label' => 'เขต',
                ],
                User::all()->whereNotIn('district_code',[1000,1402])->pluck('name', 'district_code')->toArray(),
                function ($value) {
                    $this->crud->addClause('where', 'district_office_id', $value);
                }
            );
        }

        // Year
        $this->crud->addFilter(
            [
                'name' => 'on_year',
                'type' => 'select2',
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
        $this->addFromInitiationYearTaxFields();
//        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addFromInitiationYearTaxFields();
//        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $json_data = [];
        $json_data['tax01'] = [
            'code' => 'tax01',
            'amount' => $request->input('tax01') ?? 0
        ];
        $json_data['tax02'] = [
            'code' => 'tax01',
            'amount' => $request->input('tax02') ?? 0
        ];
        $json_data['tax03'] = [
            'code' => 'tax03',
            'amount' => $request->input('tax03') ?? 0
        ];
        $json_data['tax04'] = [
            'code' => 'tax04',
            'amount' => $request->input('tax04') ?? 0
        ];


        $district_office_name = DistrictList::getDistrictName($request->input('district_office_id'))[$request->input('district_office_id')] ?? null;

        $iniTax = new InitiationYearTax();
        $iniTax->district_office_name = $district_office_name;
        $iniTax->district_office_id = $request->input('district_office_id');
        $iniTax->year = $request->input('on_year');
        $iniTax->json = json_encode($json_data);

        $iniTax->created_at = Carbon::now();
        $iniTax->updated_at = Carbon::now();
        $iniTax->save();


        return \redirect(Redirect::redirect('save_and_back', null, 'initiation-year-tax'));
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $iniTax = InitiationYearTax::whereId($id)->first();

        if (!$iniTax) {
            return 'error id not found';
        }

        $json_data = [];
        $json_data['tax01'] = [
            'code' => 'tax01',
            'amount' => $request->input('tax01') ?? 0
        ];
        $json_data['tax02'] = [
            'code' => 'tax01',
            'amount' => $request->input('tax02') ?? 0
        ];
        $json_data['tax03'] = [
            'code' => 'tax03',
            'amount' => $request->input('tax03') ?? 0
        ];
        $json_data['tax04'] = [
            'code' => 'tax04',
            'amount' => $request->input('tax04') ?? 0
        ];


        $district_office_name = DistrictList::getDistrictName($request->input('district_office_id'))[$request->input('district_office_id')] ?? null;

        $iniTax->district_office_name = $district_office_name;
        $iniTax->district_office_id = $request->input('district_office_id');
        $iniTax->year = $request->input('on_year');
        $iniTax->json = json_encode($json_data);

        $iniTax->created_at = Carbon::now();
        $iniTax->updated_at = Carbon::now();
        $iniTax->save();


        return \redirect(Redirect::redirect($request->input('save_action'), $id, 'initiation-year-tax'));
    }


    protected function addFromInitiationYearTaxFields()
    {
        $this->crud->addFields([
            [
                'name' => 'on_year',
                'label' => 'ประจำปี',
                'type' => 'select2_from_arrayInitiationYearTax',
                'options' => DateList::yearList(),
                'column_name' => 'year',
                'allows_null' => false,
                'default' => Carbon::now()->addYear(543)->year,
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'district_office_id',
                'label' => 'เขต',
                'type' => 'select2_from_arrayInitiationYearTax',
                'options' => DistrictList::districtCode(),
                'column_name' => 'district_office_id',
                'allows_null' => false,
                'default' => 0,
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax01',
                'label' => 'ภาษีโรงเรือนและที่ดิน',
                'type' => 'number',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax02',
                'label' => 'ภาษีบำรุ้งท้องที่',
                'type' => 'number',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax03',
                'label' => 'ภาษีป้าย',
                'type' => 'number',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'tax04',
                'label' => 'ภาษีที่ดินและสิ่งปลูกสร้าง',
                'type' => 'number',
                'wrapper' => ['class' => 'form-group col-md-6'],
            ]

        ]);
    }
}
