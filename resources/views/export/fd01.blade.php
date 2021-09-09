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
            <th>สนค.01 : แบบรายงานสรุปการจัดกเก็บภาษีโณงเรือนและที่ดิน ภาษีบำรุงท้องที่ ภาษีป้าย
                และภาษีที่ดินและสิ่งปลูกสร้าง
            </th>
        </tr>
        <tr>
            <th>ฝ่ายรายได้ สำนักงานเขต&emsp;{{$selected['selected_district']??null}}</th>
        </tr>
        <tr>
            <th>ประจำเดือน
                &emsp;{{$selected['selected_month']??null}} &emsp;พ.ศ.&emsp;{{$selected['selected_year']??null}} </th>
        </tr>
    </table>
</div>
<br>
<br>

<div style="width: 70%">
    {{--        tax01 ภาษีโรงเรือนและที่ดิน--}}
    <table style="text-align:center;border: 1px solid black;border-collapse: collapse; width: 100%">
        <thead style="text-align:center;border: 1px solid black;border-collapse: collapse; font-size: 13px">
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse; width: 5px" rowspan="2">ลำดับที่</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ประเภทภาษี</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">จำนวน</th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ยอดรวมแบบตั้งแต่ต้นปีงบประมาณ(รับไว้ {{isset($cumulative_year['tax01_estimated_amount_form']) ? number_format($cumulative_year['tax01_estimated_amount_form']) : null}}
                ราย ประเมินแล้ว
                {{isset($cumulative_year['tax01_estimated_amount_form']) ? number_format($cumulative_year['tax01_estimated_amount_form']) : null}}
                ราย)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ลูกหนี้ค้างชำระ(ยอดลูกหนี้ {{isset($fd['tax01_accounts_receivable_brought_forward_form']) ? number_format($fd['tax01_accounts_receivable_brought_forward_form']) : null}}
                ราย
                เป็นเงิน {{isset($fd['tax01_accounts_receivable_brought_forward_money']) ? number_format($fd['tax01_accounts_receivable_brought_forward_money'],2) : null}}
                บาท)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">ประมาณการรายรับตั้งไว้ บาท
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">
                ยอดประเมิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ยอดประเมิน(ตั้งแต่ ต.ค.
                ถึงเดือนที่รายงาน)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>

            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระคงเหลือยกมา</th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนปัจจุบัน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระยกไป</th>

            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระประจำเดือน {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">รับตั้งแต่
                ต.ค.{{$selected['selected_year_short']- 1}} - ต.ค.{{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ประมาณการคงเหลือ</th>
        </tr>
        </thead>

        <tbody style="text-align:center;border: 1px solid black;border-collapse: collapse;">
        @if(!isset($fd))
            <tr>
                <td colspan="12">ไม่มีข้อมูล</td>
            </tr>
        @else
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">1</td>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">ภาษีโรงเรือนและที่ดิน</td>
                <td style="border: 1px solid black;border-collapse: collapse">ราย</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_estimated_amount_form']) ? number_format($fd['tax01_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_estimated_amount_form']) ? number_format($cumulative_year['tax01_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_accept_payment_form']) ? number_format($fd['tax01_accept_payment_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_accounts_receivable_brought_forward_form']) ? number_format($fd['tax01_accounts_receivable_brought_forward_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_accounts_receivable_brought_forward_form']) ? number_format($cumulative_year['tax01_accounts_receivable_brought_forward_form']) : null}}</td>
                @if(isset($fd['tax01_accounts_receivable_brought_forward_form']) && isset( $fd['tax01_accounts_receivable_accept_payment_form']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax01_accounts_receivable_brought_forward_form'] - $fd['tax01_accounts_receivable_accept_payment_form'])}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse"></td>
                @endif

                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_accept_payment_monthly_form']) ? number_format($fd['tax01_accept_payment_monthly_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_accept_payment_monthly_form']) ? number_format($cumulative_year['tax01_accept_payment_monthly_form']) : null}}</td>
                @if(isset($fd['tax01_estimated_amount_money']) && isset($cumulative_year['tax01_accept_payment_monthly_money']))
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2">
                        {{number_format($fd['tax01_estimated_amount_money'] - $cumulative_year['tax01_accept_payment_monthly_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2"></td>
                @endif

            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse">เงิน</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_estimated_amount_money']) ? number_format($fd['tax01_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_estimated_amount_money']) ? number_format($cumulative_year['tax01_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_accept_payment_money']) ? number_format($fd['tax01_accept_payment_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_accounts_receivable_brought_forward_money']) ? number_format($fd['tax01_accounts_receivable_brought_forward_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_accounts_receivable_brought_forward_money']) ? number_format($cumulative_year['tax01_accounts_receivable_brought_forward_money'],2) : null}}</td>
                @if(isset($fd['tax01_accounts_receivable_brought_forward_money']) && isset($fd['tax01_accounts_receivable_accept_payment_money']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax01_accounts_receivable_brought_forward_money'] - $fd['tax01_accounts_receivable_accept_payment_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif

                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax01_accept_payment_monthly_money']) ? number_format($fd['tax01_accept_payment_monthly_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_accept_payment_monthly_money']) ? number_format($cumulative_year['tax01_accept_payment_monthly_money'],2) : null}}</td>
            </tr>
        @endif
        </tbody>


        tax02 ภาษีบำรุ้งท้องที่
        <thead style="text-align:center;border: 1px solid black;border-collapse: collapse; font-size: 13px">
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ลำดับที่</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ประเภทภาษี</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">จำนวน</th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ยอดรวมแบบตั้งแต่ต้นปีงบประมาณ(รับไว้ {{isset($cumulative_year['tax02_estimated_amount_form']) ? number_format($cumulative_year['tax02_estimated_amount_form']) : null}}
                ราย ประเมินแล้ว
                {{isset($cumulative_year['tax02_estimated_amount_form']) ? number_format($cumulative_year['tax02_estimated_amount_form']) : null}}
                ราย)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ลูกหนี้ค้างชำระ(ยอดลูกหนี้ {{isset($fd['tax02_accounts_receivable_brought_forward_form']) ? number_format($fd['tax02_accounts_receivable_brought_forward_form']) : null}}
                ราย
                เป็นเงิน {{isset($fd['tax02_accounts_receivable_brought_forward_money']) ? number_format($fd['tax02_accounts_receivable_brought_forward_money'],2) : null}}
                บาท)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">ประมาณการรายรับตั้งไว้ บาท
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">
                ยอดประเมิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ยอดประเมิน(ตั้งแต่ ต.ค.
                ถึงเดือนที่รายงาน)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>

            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระคงเหลือยกมา</th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนปัจจุบัน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระยกไป</th>

            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระประจำเดือน {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">รับตั้งแต่
                ต.ค.{{$selected['selected_year_short']- 1}} - ต.ค.{{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ประมาณการคงเหลือ</th>
        </tr>
        </thead>
        <tbody style="text-align:center;border: 1px solid black;border-collapse: collapse;">
        @if(!isset($fd))
            <tr>
                <td colspan="12">ไม่มีข้อมูล</td>
            </tr>
        @else
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">2</td>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">ภาษีบำรุ้งท้องที่</td>
                <td style="border: 1px solid black;border-collapse: collapse">ราย</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_estimated_amount_form']) ?number_format($fd['tax02_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_estimated_amount_form']) ?number_format($cumulative_year['tax02_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_accept_payment_form']) ?number_format($fd['tax02_accept_payment_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_accounts_receivable_brought_forward_form']) ?number_format($fd['tax02_accounts_receivable_brought_forward_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_accounts_receivable_brought_forward_form']) ?number_format($cumulative_year['tax02_accounts_receivable_brought_forward_form']) : null}}</td>
                @if(isset($fd['tax02_accounts_receivable_brought_forward_form']) && isset($fd['tax02_accounts_receivable_accept_payment_form']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax02_accounts_receivable_brought_forward_form'] - $fd['tax02_accounts_receivable_accept_payment_form'])}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif

                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_accept_payment_monthly_form']) ? number_format($fd['tax02_accept_payment_monthly_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_accept_payment_monthly_form']) ? number_format($cumulative_year['tax02_accept_payment_monthly_form']) : null}}</td>

                @if(isset($fd['tax02_estimated_amount_money']) && isset($cumulative_year['tax02_accept_payment_monthly_money']))
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2">
                        {{number_format($fd['tax02_estimated_amount_money'] - $cumulative_year['tax02_accept_payment_monthly_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2"></td>
                @endif

            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse">เงิน</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_estimated_amount_money']) ? number_format($fd['tax02_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_estimated_amount_money']) ? number_format($cumulative_year['tax02_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_accept_payment_money']) ? number_format($fd['tax02_accept_payment_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_accounts_receivable_brought_forward_money']) ? number_format($fd['tax02_accounts_receivable_brought_forward_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_accounts_receivable_brought_forward_money']) ? number_format($cumulative_year['tax02_accounts_receivable_brought_forward_money'],2) : null}}</td>

                @if(isset($fd['tax02_accounts_receivable_brought_forward_money']) && isset($fd['tax02_accounts_receivable_accept_payment_money']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax02_accounts_receivable_brought_forward_money'] - $fd['tax02_accounts_receivable_accept_payment_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif

                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax02_accept_payment_monthly_money']) ? number_format($fd['tax02_accept_payment_monthly_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_accept_payment_monthly_money']) ? number_format($cumulative_year['tax02_accept_payment_monthly_money'],2) : null}}</td>
            </tr>
        @endif
        </tbody>


        tax03 ภาษีป้าย
        <thead style="text-align:center;border: 1px solid black;border-collapse: collapse;font-size: 13px">
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ลำดับที่</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ประเภทภาษี</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">จำนวน</th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ยอดรวมแบบตั้งแต่ต้นปีงบประมาณ(รับไว้ {{isset($cumulative_year['tax03_estimated_amount_form']) ? number_format($cumulative_year['tax03_estimated_amount_form']) : null}}
                ราย ประเมินแล้ว
                {{isset($cumulative_year['tax03_estimated_amount_form']) ? number_format($cumulative_year['tax03_estimated_amount_form']) : null}}
                ราย)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ลูกหนี้ค้างชำระ(ยอดลูกหนี้ {{isset($fd['tax03_accounts_receivable_brought_forward_form']) ? number_format($fd['tax03_accounts_receivable_brought_forward_form']) : null}}
                ราย
                เป็นเงิน {{isset($fd['tax03_accounts_receivable_brought_forward_money']) ? number_format($fd['tax03_accounts_receivable_brought_forward_money'],2): null}}
                บาท)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">ประมาณการรายรับตั้งไว้ บาท
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">
                ยอดประเมิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ยอดประเมิน(ตั้งแต่ ต.ค.
                ถึงเดือนที่รายงาน)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>

            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระคงเหลือยกมา</th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนปัจจุบัน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระยกไป</th>

            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระประจำเดือน {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">รับตั้งแต่
                ต.ค.{{$selected['selected_year_short']- 1}} - ต.ค.{{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ประมาณการคงเหลือ</th>
        </tr>
        </thead>
        <tbody style="text-align:center;border: 1px solid black;border-collapse: collapse;">
        @if(!isset($fd))
            <tr>
                <td colspan="12">ไม่มีข้อมูล</td>
            </tr>
        @else
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">3</td>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">ภาษีป้าย</td>
                <td style="border: 1px solid black;border-collapse: collapse">ราย</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_estimated_amount_form']) ? number_format($fd['tax03_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_estimated_amount_form']) ? number_format($cumulative_year['tax03_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_accept_payment_form']) ? number_format($fd['tax03_accept_payment_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_accounts_receivable_brought_forward_form']) ? number_format($fd['tax03_accounts_receivable_brought_forward_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_accounts_receivable_brought_forward_form']) ? number_format($cumulative_year['tax03_accounts_receivable_brought_forward_form']) : null}}</td>
                @if(isset($fd['tax03_accounts_receivable_brought_forward_form']) && isset($fd['tax03_accounts_receivable_accept_payment_form']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax03_accounts_receivable_brought_forward_form'] - $fd['tax03_accounts_receivable_accept_payment_form'])}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif

                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_accept_payment_monthly_form']) ? number_format($fd['tax03_accept_payment_monthly_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_accept_payment_monthly_form']) ? number_format($cumulative_year['tax03_accept_payment_monthly_form']) : null}}</td>

                @if(isset($fd['tax03_accounts_receivable_brought_forward_money']) && isset($fd['tax01_accounts_receivable_accept_payment_money']))
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2">{{number_format($initiation_year_tax['tax03'] - $cumulative_year['tax03_accept_payment_monthly_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2">
                @endif


            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse">เงิน</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_estimated_amount_money'],) ? number_format($fd['tax03_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_estimated_amount_money']) ? number_format($cumulative_year['tax03_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_accept_payment_money']) ? number_format($fd['tax03_accept_payment_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_accounts_receivable_brought_forward_money']) ? number_format($fd['tax03_accounts_receivable_brought_forward_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_accounts_receivable_brought_forward_money']) ? number_format($cumulative_year['tax03_accounts_receivable_brought_forward_money'],2) : null}}</td>

                @if(isset($fd['tax03_accounts_receivable_brought_forward_money']) && isset($fd['tax01_accounts_receivable_accept_payment_money']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax03_accounts_receivable_brought_forward_money'] - $fd['tax01_accounts_receivable_accept_payment_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif


                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax03_accept_payment_monthly_money']) ? number_format($fd['tax03_accept_payment_monthly_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_accept_payment_monthly_money']) ? number_format($cumulative_year['tax03_accept_payment_monthly_money'],2) : null}}</td>
            </tr>
        @endif
        </tbody>


        tax04 ภาษีที่ดินและสิ่งปลูกสร้าง'
        <thead style="text-align:center;border: 1px solid black;border-collapse: collapse;font-size: 13px">
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ลำดับที่</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">ประเภทภาษี</th>
            <th style="border: 1px solid black;border-collapse: collapse" rowspan="2">จำนวน</th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ยอดรวมแบบตั้งแต่ต้นปีงบประมาณ(รับไว้ {{isset($cumulative_year['tax04_estimated_amount_form']) ? number_format($cumulative_year['tax04_estimated_amount_form']) : null}}
                ราย ประเมินแล้ว
                {{isset($cumulative_year['tax04_estimated_amount_form']) ? number_format($cumulative_year['tax04_estimated_amount_form']) : null}}
                ราย)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">
                ลูกหนี้ค้างชำระ(ยอดลูกหนี้ {{isset($fd['tax04_accounts_receivable_brought_forward_form']) ? number_format($fd['tax04_accounts_receivable_brought_forward_form']) : null}}
                ราย
                เป็นเงิน {{isset($fd['tax04_accounts_receivable_brought_forward_money']) ? number_format($fd['tax04_accounts_receivable_brought_forward_money'],2): null}}
                บาท)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="3">ประมาณการรายรับตั้งไว้ บาท
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">
                ยอดประเมิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ยอดประเมิน(ตั้งแต่ ต.ค.
                ถึงเดือนที่รายงาน)
            </th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนที่รายงาน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>

            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระคงเหลือยกมา</th>
            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระเงิน(เดือนปัจจุบัน) {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ลูกหนี้ค้างชำระยกไป</th>

            <th style="border: 1px solid black;border-collapse: collapse">
                รับชำระประจำเดือน {{$selected['selected_month_short']}} {{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">รับตั้งแต่
                ต.ค.{{$selected['selected_year_short']- 1}} - ต.ค.{{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">ประมาณการคงเหลือ</th>
        </tr>
        </thead>
        <tbody style="text-align:center;border: 1px solid black;border-collapse: collapse;">
        @if(!isset($fd))
            <tr>
                <td colspan="12">ไม่มีข้อมูล</td>
            </tr>
        @else
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">4</td>
                <td style="border: 1px solid black;border-collapse: collapse" rowspan="2">
                    ภาษีที่ดินและสิ่งปลูกสร้าง'
                </td>
                <td style="border: 1px solid black;border-collapse: collapse">ราย</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_estimated_amount_form']) ? number_format($fd['tax04_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_estimated_amount_form']) ? number_format($cumulative_year['tax04_estimated_amount_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_accept_payment_form']) ? number_format($fd['tax04_accept_payment_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_accounts_receivable_brought_forward_form']) ? number_format($fd['tax04_accounts_receivable_brought_forward_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_accounts_receivable_brought_forward_form']) ? number_format($cumulative_year['tax04_accounts_receivable_brought_forward_form']) : null}}</td>

                @if(isset($fd['tax04_accounts_receivable_brought_forward_form']) && isset($fd['tax04_accounts_receivable_accept_payment_form']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax04_accounts_receivable_brought_forward_form'] - $fd['tax04_accounts_receivable_accept_payment_form'])}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif

                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_accept_payment_monthly_form']) ? number_format($fd['tax04_accept_payment_monthly_form']) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_accept_payment_monthly_form']) ? number_format($cumulative_year['tax04_accept_payment_monthly_form']) : null}}</td>

                @if(isset($fd['tax04_estimated_amount_money']) && isset($cumulative_year['tax04_accept_payment_monthly_money']))
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2">
                        {{number_format($fd['tax04_estimated_amount_money'] - $cumulative_year['tax04_accept_payment_monthly_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse"
                        rowspan="2"></td>
                @endif

            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse">เงิน</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_estimated_amount_money']) ? number_format($fd['tax04_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_estimated_amount_money']) ? number_format($cumulative_year['tax04_estimated_amount_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_accept_payment_money']) ? number_format($fd['tax04_accept_payment_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_accounts_receivable_brought_forward_money']) ? number_format($fd['tax04_accounts_receivable_brought_forward_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_accounts_receivable_brought_forward_money']) ? number_format($cumulative_year['tax04_accounts_receivable_brought_forward_money'],2) : null}}</td>

                @if(isset($initiation_year_tax['tax04']) && isset($cumulative_year['tax04_accept_payment_monthly_money']))
                    <td style="border: 1px solid black;border-collapse: collapse">{{number_format($fd['tax04_accounts_receivable_brought_forward_money'] - $fd['tax04_accounts_receivable_accept_payment_money'],2)}}</td>
                @else
                    <td style="border: 1px solid black;border-collapse: collapse">
                @endif
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($fd['tax04_accept_payment_monthly_money']) ? number_format($fd['tax04_accept_payment_monthly_money'],2) : null}}</td>
                <td style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_accept_payment_monthly_money']) ? number_format($cumulative_year['tax04_accept_payment_monthly_money'],2) : null}}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <br>
    <br>
    <table style="text-align:center;border: 1px solid black;border-collapse: collapse; width: 70%">
        <thead style="text-align:center;border: 1px solid black;border-collapse: collapse; font-size: 13px">
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse"></th>
            <th style="border: 1px solid black;border-collapse: collapse" colspan="5">ประมาณการ/ผลการจัดเก็บภาษี 3
                ประเภท
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">ประมาณการ/การจัดเก็บจริง</th>
            <th style="border: 1px solid black;border-collapse: collapse">ภาษีโรงเรือนและที่ดิน</th>
            <th style="border: 1px solid black;border-collapse: collapse">ภาษีบำรุงท้องที่</th>
            <th style="border: 1px solid black;border-collapse: collapse">ภาษีป้าย</th>
            <th style="border: 1px solid black;border-collapse: collapse">ภาษีที่ดินและสิ่งปลูกสร้าง</th>
            <th style="border: 1px solid black;border-collapse: collapse">รวม</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">ประมาณการรายรับปีงบประมาณ
                ปี {{$selected['selected_year']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($initiation_year_tax['tax01']) ? number_format($initiation_year_tax['tax01'],2) : null}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($initiation_year_tax['tax02']) ? number_format($initiation_year_tax['tax02'],2) : null}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($initiation_year_tax['tax03']) ? number_format($initiation_year_tax['tax03'],2) : null}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($initiation_year_tax['tax04']) ? number_format($initiation_year_tax['tax04'],2) : null}}</th>
            @if(isset($initiation_year_tax['tax01']) && isset($initiation_year_tax['tax02']) && isset($initiation_year_tax['tax03']) && isset($initiation_year_tax['tax04']) )
                <th style="border: 1px solid black;border-collapse: collapse">{{number_format($initiation_year_tax['tax01'] + $initiation_year_tax['tax02'] + $initiation_year_tax['tax03'] + $initiation_year_tax['tax04'],2)}}</th>
            @else
                <th style="border: 1px solid black;border-collapse: collapse"></th>
            @endif
        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">จัดเก็บได้ตั้งแต่
                ต.ค.{{$selected['selected_year_short']- 1}} - ต.ค.{{$selected['selected_year_short']}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax01_accept_payment_monthly_money']) ? number_format($cumulative_year['tax01_accept_payment_monthly_money'],2) : null}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax02_accept_payment_monthly_money']) ? number_format($cumulative_year['tax02_accept_payment_monthly_money'],2) : null}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax03_accept_payment_monthly_money']) ? number_format($cumulative_year['tax03_accept_payment_monthly_money'],2) : null}}</th>
            <th style="border: 1px solid black;border-collapse: collapse">{{isset($cumulative_year['tax04_accept_payment_monthly_money']) ? number_format($cumulative_year['tax04_accept_payment_monthly_money'],2) : null}}</th>

            @if(isset($cumulative_year['tax01_accept_payment_monthly_money']) && isset($cumulative_year['tax02_accept_payment_monthly_money']) && isset($cumulative_year['tax03_accept_payment_monthly_money']) && isset($cumulative_year['tax04_accept_payment_monthly_money']) )
                <th style="border: 1px solid black;border-collapse: collapse">{{number_format($cumulative_year['tax01_accept_payment_monthly_money'] + $cumulative_year['tax02_accept_payment_monthly_money']+ $cumulative_year['tax03_accept_payment_monthly_money'] + $cumulative_year['tax04_accept_payment_monthly_money'],2)}}</th>
            @else
                <th style="border: 1px solid black;border-collapse: collapse"></th>
            @endif


        </tr>
        <tr>
            <th style="border: 1px solid black;border-collapse: collapse">คิดเป็นร้อยละของการประมาณการ</th>
            @if(isset($initiation_year_tax['tax01']))
                <th style="border: 1px solid black;border-collapse: collapse">{{$initiation_year_tax['tax01'] != 0 || $initiation_year_tax['tax01'] !== null ? number_format(($cumulative_year['tax01_accept_payment_monthly_money'] * 100) / $initiation_year_tax['tax01'],2) : 'ไม่มีค่าตั้งต้น'}}</th>
            @else
                <th style="border: 1px solid black;border-collapse: collapse">ไม่มีค่าตั้งต้น</th>
            @endif

            @if(isset($initiation_year_tax['tax02']))
                <th style="border: 1px solid black;border-collapse: collapse">{{$initiation_year_tax['tax02'] != 0 || $initiation_year_tax['tax02'] !== null ? number_format(($cumulative_year['tax02_accept_payment_monthly_money'] * 100) / $initiation_year_tax['tax02'],2) : 'ไม่มีค่าตั้งต้น'}}</th>
            @else
                <th style="border: 1px solid black;border-collapse: collapse">ไม่มีค่าตั้งต้น</th>
            @endif

            @if(isset($initiation_year_tax['tax03']))
                <th style="border: 1px solid black;border-collapse: collapse">{{$initiation_year_tax['tax03'] != 0 || $initiation_year_tax['tax03'] !== null ? number_format(($cumulative_year['tax03_accept_payment_monthly_money'] * 100) / $initiation_year_tax['tax03'],2) : 'ไม่มีค่าตั้งต้น'}}</th>
            @else
                <th style="border: 1px solid black;border-collapse: collapse">ไม่มีค่าตั้งต้น</th>
            @endif

            @if(isset($initiation_year_tax['tax04']))
                <th style="border: 1px solid black;border-collapse: collapse">{{$initiation_year_tax['tax04'] != 0 || $initiation_year_tax['tax04'] !== null ? number_format(($cumulative_year['tax04_accept_payment_monthly_money'] * 100) / $initiation_year_tax['tax04'],2) : 'ไม่มีค่าตั้งต้น'}}</th>
            @else
                <th style="border: 1px solid black;border-collapse: collapse">ไม่มีค่าตั้งต้น</th>
            @endif


            <th style="border: 1px solid black;border-collapse: collapse"></th>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

