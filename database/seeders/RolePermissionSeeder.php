<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->get()->pluck('id', 'name');

        foreach ($roles as $r) {
            switch ($r->name) {
                case 'Super Admin' :
                    foreach ($permissions as $p_name => $p_id) {
                        DB::table('role_has_permissions')->insert([
                            'permission_id' => $p_id,
                            'role_id' => $r->id,
                        ]);
                    }
                    break;
                case 'Central' :
                case 'District' :
                    $user_permission = ['Form สนค.01', 'Form สนค.02-1', 'Form สนค.02-2', 'Form สนค.02-3', 'Form สนค.02-4', 'Form จำนวนแบบยื่น/จำนวนราย',
                        'Report สนค.01', 'Report สนค.02-1', 'Report สนค.02-2', 'Report สนค.02-3', 'Report สนค.02-4', 'Report จำนวนแบบยื่น/จำนวนราย', 'Report สรุปข้อมูลแยกตามปีงบ'];

                foreach ($user_permission as $up_name) {
                    if(isset($permissions[$up_name])){
                        DB::table('role_has_permissions')->insert([
                            'permission_id' => $permissions[$up_name],
                            'role_id' => $r->id,
                        ]);
                    }
                }
                    break;

            }

        }


    }
}
