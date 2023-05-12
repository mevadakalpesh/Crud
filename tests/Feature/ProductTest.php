<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
class ProductTest extends TestCase
{
  use RefreshDatabase;
  /**
  * A basic feature test example.
  */
  public function test_product_view_is_working() {
    $response = $this->get('/product');
    $response->assertSuccessful();
    $response->assertViewIs('products.product-listing');
    $response->assertStatus(200);
  }

  public function test_product_can_be_created_with_image() {
    $rr = Storage::fake(config('constant.storage_type'));
  
    $file = UploadedFile::fake()->image('product.jpg');
    $data = [
      'name' => 'Test Product',
      'amount' => rand(0,999),
      'image' => $file,
      'status' => array_rand([1,2]),
      'description' => 'this is tets'
    ];
    
    $response = $this->post(route('product.store'), $data);
    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    $file_name = Product::first()->image;
    $this->assertNotNull($file_name);
    Storage::disk(config('constant.storage_type'))->assertExists($file_name);
  }

}