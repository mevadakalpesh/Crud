<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use App\Models\User;
class ProductTest extends TestCase
{
  use RefreshDatabase;
  /**
  * A basic feature test example.
  */

  public function authorize() {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/home');
    $response->assertStatus(200);
    return $user;
  }

  public function create_product() {
    $rr = Storage::fake(config('constant.storage_type'));
    $file = UploadedFile::fake()->image('product.jpg');
    $data = [
      'name' => 'Test Product',
      'amount' => rand(0, 999),
      'image' => $file,
      'status' => array_rand([1, 2]),
      'description' => 'this is tets'
    ];
    $response = $this->post(route('product.store'), $data);
    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    return $response;
  }


  public function test_unauth_user_redirect_to_login_while_access_product() {
    $response = $this->get('/product');
    $response->assertStatus(302);
    $response->assertRedirect('/login');
  }

  public function test_product_can_be_created_with_image() {

    $this->authorize();
    $response = $this->create_product();
    $product = Product::first();
    $file_name = DB::table('products')->select('image')->first();
    $file_name = $file_name->image;
    $this->assertNotNull($file_name);
    Storage::disk(config('constant.storage_type'))->assertExists('product-images/'.$file_name);
    //for edit
    $response = $this->get(route('product.edit', $product->id));
    $response->assertStatus(200);
  }

  public function test_edit_product() {
    $this->authorize();
    $response = $this->create_product();
    $product = Product::first();
    $response = $this->get(route('product.edit', $product->id));
    $response->assertStatus(200);
  }

  public function test_update_product() {
    $this->authorize();
    $this->create_product();
    $product = Product::first();
    $rr = Storage::fake(config('constant.storage_type'));
    $file = UploadedFile::fake()->image('product.jpg');
    $data = [
      'name' => 'Test Product Update',
      'amount' => rand(0, 999),
      'image' => $file,
      'status' => array_rand([1, 2]),
      'description' => 'this is updated description'
    ];

    $response = $this->put(route('product.update', $product->id), $data);
    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('products', ['name' => 'Test Product Update']);
    $response->assertStatus(200);
  }

  public function test_check_delete_product() {
    $this->authorize();
    $this->create_product();
    $product = Product::first();
    $response = $this->delete(route('product.destroy', $product->id));
    $this->assertDatabaseMissing('products', ['deleted_at' => null]);
    $response->assertStatus(200);
  }
}