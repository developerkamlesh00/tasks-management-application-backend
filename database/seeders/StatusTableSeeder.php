<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['to-do', 'doing', 'under-review','completed'];
        foreach ($status as $status) {
            Status::create([
                'status_name' => $status,
            ]);
        }
    }
}
