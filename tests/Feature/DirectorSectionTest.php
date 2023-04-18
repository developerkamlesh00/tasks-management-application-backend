<?php

namespace Tests\Feature;

use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use app\Models\User;

class DirectorSectionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    //register Organization test
    public function test_register_organization()
    {
        $org = [
            "org_name" => "Temp Organization Created",
            "org_email" => "org@gmail.com",
            "name" => "Kamlesh Jamadar",
            "email" => "kamlesh@gmail.com",
            "password" => "Admin@123",
        ];
        $response = $this->post('api/orgregister',$org);
        $response->assertStatus(200);
    }

    //set Header function for api auth //make header with auth token
    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];

        if (!is_null($user)) {
            $token = $user->createToken('Token Name')->accessToken;
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    //get organization information test
    public function test_get_organization_info(){

        $user = User::find(2);
        $org = Organization::find(2);
        $response = $this->get("/api/director/organization/$org->id",$this->headers($user));
        // dd($response);
        $response->assertStatus(200);
        $this->assertTrue(true);
    }

    
    //get own data using api auth
    public function test_getUser_test(){

        $user = User::find(2);
        $response = $this->get('/api/director/getuser/2',$this->headers($user));
        $response->assertStatus(200);
        $this->assertTrue(true);
    }

    //create manager and worker endpoint apis
    public function test_create_manager_apis(){

        $user = User::find(2);
        $manager = [
            "name" => 'Manager',
            "email" => 'manager1@gmail.com',
            "password" => 'Admin@123',
            "organization_id" => $user->organization_id,
            "role_id" => 3
        ];
        $response = $this->post('api/director/register',$manager , $this->headers($user));
        $response->assertStatus(200);
        $responseData = $response->json();
        return $responseData;
    }

    //create manager and worker endpoint apis
    public function test_create_worker_apis(){
        $user = User::find(2);
        $worker = [
            "name" => 'Worker',
            "email" => 'Worker1@gmail.com',
            "password" => 'Admin@123',
            "organization_id" => $user->organization_id,
            "role_id" => 4
        ];
        $response = $this->post('api/director/register',$worker , $this->headers($user));
        $response->assertStatus(200);
        $responseData = $response->json();
        return $responseData;
    }

    //crate project apis test
    public function test_create_project_apis(){
        $manager = $this->test_create_manager_apis(); //create and return token
        $managerobj = User::find($manager['userId']);
        $assigned = now();
        $project = [
            "title" => 'Testing Project',
            "description" => 'testing project description',
            "assigned_at" => $assigned,
            "estimated_deadline" => date_add($assigned , date_interval_create_from_date_string('2 weeks')),
            "organization_id" => $managerobj->organization_id,
            "manager_id" => $manager['userId']
        ];
        $response = $this->post("/api/director/createproject",$project, $this->headers($managerobj));
        $response->assertStatus(200);
    }

    //get all project to specific organization
    public function test_get_projects(){
        $user = User::find(2);
        $response = $this->get("api/director/projects/$user->organization_id",$this->headers($user));
        $response->assertStatus(200);
    }

    //get all managers to organization
    public function test_get_managers(){
        $user = User::find(2);
        $response = $this->get("api/director/managers/$user->organization_id",$this->headers($user));
        $response->assertStatus(200);
    }

    //get all worker to organization
    public function test_get_workers(){
        $user = User::find(2);
        $response = $this->get("api/director/workers/$user->organization_id",$this->headers($user));
        $response->assertStatus(200);
    }

    //update profile apis
    public function test_update_profile(){
        $user = User::find(2);
        $user['name'] = "Name Change Kamlesh";
        $response = $this->post("api/director/updateuser/$user->id",$user->toArray(),$this->headers($user));
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'Name Change Kamlesh',
        ]);//check this name available inside database users table or not
    }

    //update organization
    public function test_update_organization(){
        $user = User::find(2);
        $org = Organization::find(2);
        $org['org_name'] = "Name Change Testing Organization";
        $response = $this->post("api/director/updateorg",$org->toArray(),$this->headers($user));
        $response->assertStatus(200);
        $this->assertDatabaseHas('organizations',[
            'org_name' => 'Name Change Testing Organization',
        ]);//check after change name its avaible inside database
    }


    //some basics tests
    public function test_general(){
        $user = User::find(2);
        $this->assertModelExists($user);//check available or not

        $user->delete(); //delete user then check its available or not
        $this->assertModelMissing($user);
    }

    public function testDeleteManager()
    {
        $user = User::find(2);
        $manager = User::find(10);
        $response = $this->post("api/admin/users/$manager->id", $this->headers($user));
        $response->assertStatus(200);
    }

    public function testDeleteWorker()
    {
        $user = User::find(2);
        $worker = User::find(22);
        $response = $this->post("api/admin/users/$worker->id", $this->headers($user));
        $response->assertStatus(200);
    }
    
}
