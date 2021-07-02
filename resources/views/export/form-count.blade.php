<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ url('fonts/THSarabunNew.ttf') }}") format(ftruetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ url('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ url('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ url('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        body {
            font-family: "THSarabunNew";
        }
    </style>
</head>
<body>
<div>
    <table style="text-align:center; width: 100%">
        <tr>
            <th>จำนวนแบบยื่น/จำนวนราย</th>
        </tr>
        <tr>
            <th>ฝ่ายรายได้</th>
        </tr>
        <tr>
            <th>สำนักงานเขต&emsp;{{$selected_district??null}}</th>
        </tr>
        <tr>
            <th>ประจำเดือน
                &emsp;{{$selected_month??null}} &emsp;พ.ศ.&emsp;{{$selected_year??null}} </th>
        </tr>
    </table>
</div>

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
</body>
</html>

