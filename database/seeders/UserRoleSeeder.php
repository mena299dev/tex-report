<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = DB::table('roles')->get()->pluck('id','name');
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            switch ($user->district_code) {
                case '0000':
                    DB::table('model_has_roles')->insert([
                        'role_id' => $roles['Super Admin'],
                        'model_type' => 'App\Models\User',
                        'model_id' => $user->id,
                    ]);
                    break;
                case '1402':
                    DB::table('model_has_roles')->insert([
                        'role_id' => $roles['Central'],
                        'model_type' => 'App\Models\User',
                        'model_id' => $user->id,
                    ]);
                    break;
                default:
                    DB::table('model_has_roles')->insert([
                        'role_id' => $roles['District'],
                        'model_type' => 'App\Models\User',
                        'model_id' => $user->id,
                    ]);
                    break;
            }
        }
    }
}
