@extends(backpack_view('blank'))
@section('content')
    <h2>สนค.02-04</h2>
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


            @role('Central')
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
                <th>สนค.02-4 : แบบรายงานการจัดเก็บภาษีค้างชำระที่ดินและสิ่งปลูกสร้าง</th>
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
                <th style="border: 1px solid black;border-collapse: collapse">ลำดับ</th>
                <th style="border: 1px solid black;border-collapse: collapse">รายชื่อผู้ค้างชำระ</th>
                <th style="border: 1px solid black;border-collapse: collapse">ปีที่ค้างชำระ</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนเงิน ค่าภาษี</th>
                <th style="border: 1px solid black;border-collapse: collapse">ค่าเบี้ยปรับ</th>
                <th style="border: 1px solid black;border-collapse: collapse">ค่าเงินเพิ่ม</th>
                <th style="border: 1px solid black;border-collapse: collapse">จำนวนเงิน รวม</th>
                <th style="border: 1px solid black;border-collapse: collapse">เลขที่ออกหนังสือ</th>
                <th style="border: 1px solid black;border-collapse: collapse">วันที่รับชำระ</th>
                <th style="border: 1px solid black;border-collapse: collapse">หมายเหตุ</th>
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
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['sequence'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['defaulter_name'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['defaulter_year'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{number_format($data['tax_amount'] ,2)?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{number_format($data['fine_amount'] ,2)?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{number_format($data['increment_amount'] ,2)?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{number_format($data['tax_amount'] + $data['fine_amount'] + $data['increment_amount'],2)?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['book_number'] ?? null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['date_of_payment_str'] ??  null}}</td>
                        <td style="border: 1px solid black;border-collapse: collapse">{{$data['remark'] ?? null}}</td>
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
