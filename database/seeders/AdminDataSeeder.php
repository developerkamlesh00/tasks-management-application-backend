<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        Organization::create([
            'org_email' => 'admin@gmail.com',
            'org_name' => 'admin organization',
        ]);

        $pass = bcrypt('Admin@123');
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => $pass,
            'organization_id' => 1,
            'role_id' => 1,
        ]);
    }
}
