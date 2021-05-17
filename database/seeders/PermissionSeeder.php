<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Form ประมาณการรายรับประจำปีงบประมาณ',
            'Form สนค.01',
            'Form สนค.02-1',
            'Form สนค.02-2',
            'Form สนค.02-3',
            'Form สนค.02-4',
            'Form จำนวนแบบยื่น/จำนวนราย',

            'Report สนค.01',
            'Report สนค.02-1',
            'Report สนค.02-2',
            'Report สนค.02-3',
            'Report สนค.02-4',
            'Report จำนวนแบบยื่น/จำนวนราย',
            'Report สรุปข้อมูลแยกตามปีงบ',
        ];

        foreach ($permissions as $p){
            DB::table('permissions')->insert([
                'name' => $p,
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        }

}
