<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Client;
use Tests\TestCase;
use GuzzleHttp\Psr7\Request;

class AdminSectionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $credentials = [
            "email" => "admin@gmail.com",
            "password" => "Admin@123"
        ];
        $response = $this->post('api/login', $credentials);

        $response->assertStatus(200);
        return $response;
    }

    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];

        if (!is_null($user)) {
            $token = $user->createToken('Token Name')->accessToken;
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    public function test_get_organizations()
    {
        $user = User::find(1);
        $response = $this->get("api/admin/organizations", $this->headers($user));
        $response->assertStatus(200);
    }

    public function test_get_directors()
    {
        $user = User::find(1);
        $response = $this->get("api/admin/directors", $this->headers($user));
        $response->assertStatus(200);
    }

    public function test_get_managers()
    {
        $user = User::find(1);
        $response = $this->get("api/admin/managers", $this->headers($user));
        $response->assertStatus(200);
    }


    public function test_get_workers()
    {
        $user = User::find(1);
        $response = $this->get("api/admin/workers", $this->headers($user));
        $response->assertStatus(200);
    }

    
    // public function testDeleteManager()
    // {
    //     $user = User::find(1);
    //     $response = $this->post("api/admin/users/5", $this->headers($user));
    //     $response->assertStatus(200);
      
    // }
    
}