<?php

namespace Tests;

use App\Models\Organization;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class'=>'DatabaseSeeder', '--database' => 'sqlite_testing']);
        Artisan::call('passport:install');
    }

    protected function testingOrg(){
        return Organization::create([
            'org_email' => 'testing@gmail.com',
            'org_name' => 'Testing Organization',
            'total_projects' => 10,
        ]);
    }

    public function test_login()
    {
        $credential = [
            "email" => "director@gmail.com",
            "password" => "Admin@123"
        ];

        $response = $this->post('api/login',$credential);
        $response->assertStatus(200);

        $this->assertTrue(true);
        return $response;
    }
}
