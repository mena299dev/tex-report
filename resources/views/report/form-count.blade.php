@extends(backpack_view('blank'))
@section('content')
    <h2>จำนวนแบบยื่น/จำนวนราย</h2>
    <form>
        <div class="from-group">
            @role('Super Admin')
            <select name="district" id="district" style="width: 15%">
                @foreach ($district as $key => $value)
                    @if(request('district') == $key)
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>
            @endrole
            <select name="on_month" id="on_month" style="width: 15%">
                @foreach ($month_list as $key => $value)
                    @if(request('on_month') == $key)
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>

            <select name="on_year" id="on_year" style="width: 15%">
                @foreach ($year_list as $key => $value)
                    @if(request('on_year') == $key)
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>

            <button type="submit" class="btn btn-success" value="preview" name="btn_type">
                <span data-value="save_and_back">ค้นหา</span>
            </button>
            <button type="submit" class="btn btn-success" value="download" name="btn_type">
                <span data-value="save_and_back">Download</span>
            </button>
        </div>
    </form>
    <br>
    <br>
    <div>
        <table style="text-align:center; width: 100%">
            <tr>
                <th>จำนวนแบบยื่น/จำนวนราย</th>
            </tr>
            <tr>
                <th>ฝ่ายรายได้</th>
            </tr>
            <tr>
                <th>สำนักงานเขต&emsp;{{$selected['selected_district']??null}}</th>
            </tr>
            <tr>
                <th>ประจำเดือน
                    &emsp;{{$selected['selected_month']??null}} &emsp;พ.ศ.&emsp;{{$selected['selected_year']??null}} </th>
            </tr>
        </table>
    </div>
    <br>
    <br>

    <div>
        <table style="text-align:center;border: 1px solid black;border-collapse: collapse; width: 100%">
            <thead style="text-align:center;border: 1px solid black;border-collapse: collapse">
            <tr>
                <th style="border: 1px solid black;border-collapse: collapse" colspan="2">ภาษีโรงเรือนและที่ดิน</th>
                <th style="border: 1px solid black;border-collapse: collapse" colspan="2">ภาษีบำรุงท้องที่</th>
                <th style="border: 1px solid black;border-collapse: collapse" colspan="2">ภาษีป้าย</th>
                <th style="border: 1px solid black;border-collapse: collapse" colspan="3">ภาษีที่ดินและสิ่งปลูกสร้าง</th>
            </tr>
            <tr>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนแบบยื่น (ราย)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนรหัสประจำบ้าน (หลัง)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนแบบยื่น (ราย)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนแปลง (แปลง)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนแบบยื่น (ราย)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนป้าย (ป้าย)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนแปลงที่ดิน</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนรหัสประจำบ้าน (หลัง)</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนผู้เสียภาษี (ราย)</th>
            </tr>
            </thead>

            <tbody style="text-align:center;border: 1px solid black;border-collapse: collapse;">
            @if(!isset($fd) || count($fd) == 0)
                <tr>
                    <td colspan="10">ไม่มีข้อมูล</td>
                </tr>
            @else
                @foreach($fd as $data)
                    <tr>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax01_serving_form'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax01_code_house'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax02_serving_form'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax02_count_land'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax03_serving_form'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax03_count_tablet'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax04_count_land'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax04_code_house'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['tax04_tax_customer'] ?? null}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <script>
        $('#district').select2();
        $('#on_month').select2();
        $('#on_year').select2();

    </script>
@endsection
