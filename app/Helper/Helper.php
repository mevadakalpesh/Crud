<?php
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

function storeFile($folder,$file,$prefix){
  //thumbnail Image
  
  $fileName = $prefix.'_'.$file->hashName();
  /*if($file->path()){
    $path = Storage::disk(config('constant.storage_type'))->path('/');
    $img = Image::make($file->path())
    ->resize(80, 80, function ($constraint) {
          $constraint->aspectRatio();
    })
    ->save($path.$folder.'thumb/'.$fileName,99);
  }*/
  
  Storage::disk(config('constant.storage_type'))->putFileAs($folder,$file,$fileName);
  return $fileName;
}


function sanitize($line){
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $line); // attempt to translate similar characters
   $clean = preg_replace('/[^\w]/', '', $clean); // drop anything but ASCII
   return $clean;
}
