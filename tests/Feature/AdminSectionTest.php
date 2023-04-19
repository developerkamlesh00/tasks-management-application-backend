<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Laravel\Passport\Client;
use Egulias\EmailValidator\Exception\ConsecutiveAt;
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

    public function testDeleteUser()
    {
        $user = User::factory()->create();
        
        $response = $this->delete('/api/admin/users/' . $user->id);
        
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // public function testDeleteDirectorUser()
    // {
    //     $org = Organization::factory()->create();
    //     $director = User::factory()->create(['role_id' => 2, 'organization_id' => $org->id]);
    //     $manager = User::factory()->create(['role_id' => 3, 'organization_id' => $org->id]);
    //     $worker = User::factory()->create(['role_id' => 4, 'organization_id' => $org->id]);
        
    //     $response = $this->delete('/api/admin/users/' . $director->id);
        
    //     $response->assertStatus(200);
    //     $this->assertDatabaseMissing('users', ['id' => $director->id]);
    //     $this->assertDatabaseMissing('users', ['id' => $manager->id]);
    //     $this->assertDatabaseMissing('users', ['id' => $worker->id]);
    //     $this->assertDatabaseMissing('organizations', ['id' => $org->id]);
    // }
//in OrganizationFactory
//     class OrganizationFactory extends Factory
//     {
//         protected $model = Organization::class;

//         public function definition()
//         {
//             return [
//                 'name' => $this->faker->company,
//             ];
//         }
//     }
//  //in seeder
//     public function run()
//     {
//     // ...
//         Organization::factory()->count(5)->create();
//     }
    
public function testFilterByPrice() {
    // Mock data
    $products = [
      ['name' => 'Product 1', 'price' => 10],
      ['name' => 'Product 2', 'price' => 20],
      ['name' => 'Product 3', 'price' => 30],
      ['name' => 'Product 4', 'price' => 40],
      ['name' => 'Product 5', 'price' => 50]
    ];

    // Filter products by price greater than 30
    $filteredProducts = array_filter($products, function($product) {
      return $product['price'] > 30;
    });

    // Assert that only products with prices greater than 30 are returned
    $this->assertCount(2, $filteredProducts);
    $this->assertEquals('Product 4', $filteredProducts[0]['name']);
    $this->assertEquals('Product 5', $filteredProducts[1]['name']);
  }

  public function testSearchByName() {
    // Mock data
    $products = [
      ['name' => 'Apple', 'price' => 10],
      ['name' => 'Banana', 'price' => 20],
      ['name' => 'Cherry', 'price' => 30],
      ['name' => 'Dragonfruit', 'price' => 40],
      ['name' => 'Elderberry', 'price' => 50]
    ];

    // Search for products containing 'berry' in the name
    $searchedProducts = array_filter($products, function($product) {
      return strpos($product['name'], 'berry') !== false;
    });

    // Assert that only products containing 'berry' in the name are returned
    $this->assertCount(1, $searchedProducts);
    $this->assertEquals('Elderberry', $searchedProducts[0]['name']);
    $this->assertEquals('Huckleberry', $searchedProducts[1]['name']);    
  }
    
}