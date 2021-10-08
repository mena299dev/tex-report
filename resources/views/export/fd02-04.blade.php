<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ url('fonts/THSarabunNew.ttf') }}") format('truetype');
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
            <th>สนค.02-4 : แบบรายงานการจัดเก็บภาษีค้างชำระที่ดินและสิ่งปลูกสร้าง</th>
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
            <th style="border: 1px solid black;border-collapse: collapse">ลำดับ</th>
            <th style="border: 1px solid black;border-collapse: collapse">รายชื่อผู้ค้างชำระ</th>
            <th style="border: 1px solid black;border-collapse: collapse">ปีที่ค้างชำระ</th>
            <th style="border: 1px solid black;border-collapse: collapse">จำนวนเงิน ค่าภาษี</th>
            <th style="border: 1px solid black;border-collapse: collapse">ค่าเบี้ย</th>
            <th style="border: 1px solid black;border-collapse: collapse">ค่าเพิ่ม</th>
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
</body>
</html>

