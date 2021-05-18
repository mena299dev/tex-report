<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $district = [
            ['code' => '1402', 'name' => 'ส่วนกลาง'],
            ['code' => '5001', 'name' => 'พระนคร'],
            ['code' => '5002', 'name' => 'ป้อมปราบศัตรูพ่าย'],
            ['code' => '5003', 'name' => 'สัมพันธวงศ์'],
            ['code' => '5004', 'name' => 'บางรัก'],
            ['code' => '5005', 'name' => 'ปทุมวัน'],
            ['code' => '5006', 'name' => 'ยานนาวา'],
            ['code' => '5007', 'name' => 'ดุสิต'],
            ['code' => '5008', 'name' => 'พญาไท'],
            ['code' => '5009', 'name' => 'ห้วยขวาง'],
            ['code' => '5010', 'name' => 'พระโขนง'],
            ['code' => '5011', 'name' => 'บางกะปิ'],
            ['code' => '5012', 'name' => 'บางเขน'],
            ['code' => '5013', 'name' => 'มีนบุรี'],
            ['code' => '5014', 'name' => 'ลาดกระบัง'],
            ['code' => '5015', 'name' => 'หนองจอก'],
            ['code' => '5016', 'name' => 'ธนบุรี'],
            ['code' => '5017', 'name' => 'คลองสาน'],
            ['code' => '5018', 'name' => 'บางกอกใหญ่'],
            ['code' => '5019', 'name' => 'บางกอกน้อย'],
            ['code' => '5020', 'name' => 'ตลิ่งชัน'],
            ['code' => '5021', 'name' => 'ภาษีเจริญ'],
            ['code' => '5022', 'name' => 'หนองแขม'],
            ['code' => '5023', 'name' => 'บางขุนเทียน'],
            ['code' => '5024', 'name' => 'ราษฎร์บูรณะ'],
            ['code' => '5025', 'name' => 'ดอนเมือง'],
            ['code' => '5026', 'name' => 'จตุจักร'],
            ['code' => '5027', 'name' => 'ลาดพร้าว'],
            ['code' => '5028', 'name' => 'บึงกุ่ม'],
            ['code' => '5029', 'name' => 'สาทร'],
            ['code' => '5030', 'name' => 'บางคอแหลม'],
            ['code' => '5031', 'name' => 'บางซื่อ'],
            ['code' => '5032', 'name' => 'ราชเทวี'],
            ['code' => '5033', 'name' => 'คลองเตย'],
            ['code' => '5034', 'name' => 'ประเวศ'],
            ['code' => '5035', 'name' => 'บางพลัด'],
            ['code' => '5036', 'name' => 'จอมทอง'],
            ['code' => '5037', 'name' => 'ดินแดง'],
            ['code' => '5038', 'name' => 'สวนหลวง'],
            ['code' => '5039', 'name' => 'วัฒนา'],
            ['code' => '5040', 'name' => 'บางแค'],
            ['code' => '5041', 'name' => 'หลักสี่'],
            ['code' => '5042', 'name' => 'สายไหม'],
            ['code' => '5043', 'name' => 'คันนายาว'],
            ['code' => '5044', 'name' => 'สะพานสูง'],
            ['code' => '5045', 'name' => 'วังทองหลาง'],
            ['code' => '5046', 'name' => 'คลองสามวา'],
            ['code' => '5047', 'name' => 'บางนา'],
            ['code' => '5048', 'name' => 'ทวีวัฒนา'],
            ['code' => '5049', 'name' => 'ทุ่งครุ'],
            ['code' => '5050', 'name' => 'บางบอน']
        ];


        foreach ($district as $d) {
            DB::table('district')->insert([
                'code' => $d['code'],
                'name' => $d['name'],
            ]);
        }
    }
}
