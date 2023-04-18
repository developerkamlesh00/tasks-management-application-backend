<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'director', 'manager','worker'];
        foreach ($roles as $role) {
            Role::create([
                'role_name' => $role,
            ]);
        }
    }
}
