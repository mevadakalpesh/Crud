<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $guarded = [];
    protected $appends =['product_thum_img'];
    protected $casts = [
      "amount" => "decimal:2",
      "created_at" =>'date:Y-m-d'
    ];
    
    //make sure add forlder like thubmanil
    public static $filePath = 'product-images/';
    
    //status 1 : pending , 2 : completed
    public static $pendingStatus = 1;
    public static $completedStatus = 2;
    
    public function scopeExceptCol($query,$exceptCol = []){
      $modelColums = Schema::getColumnListing(app(Product::class)->getTable());
      return $query->select(array_diff($modelColums,$exceptCol));
    }
  
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  (!blank($value))  ? config('constant.storage_path').self::$filePath.$value : config('constant.default_image').$value,
        );
    }
    
    protected function getProductThumImgAttribute()
    {    
        return $this->attributes['product_thum_img'] = (!blank($this->attributes["image"]))  ?
        config('constant.storage_path').self::$filePath.'thumb/'.$this->attributes["image"] :
        config('constant.default_image').$this->attributes["image"];
    }
}
