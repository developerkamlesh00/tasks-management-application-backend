<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    // check login endpoint and responsed is correct or not
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

    //test for forgot password send email
    public function test_forgot_generate_link_token()
    {
        $credential = [
            "email" => "director@gmail.com"
        ];
    
        $response = $this->post('api/forgot',$credential);
        $response->assertStatus(200);
        $this->assertTrue(true);
    
        $responseData = $response->json();
        $token = $responseData['token'];
        return $token;
    }
    
    // reset password check endpoint
    public function test_reset_password_link(){
    
        $forgot = $this->test_forgot_generate_link_token();
        $data = [
            "password" => "Admin@123",
            "token" => $forgot,
        ];
        $response = $this->post('api/resetpassword',$data);
        $response->assertStatus(200);
        $this->assertTrue(true);
    }
    
}
