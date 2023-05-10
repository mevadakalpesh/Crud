<?php
use Illuminate\Support\Facades\Storage;


function storeFile($folder,$file,$prefix){
  $fileName = $prefix.'_'.$file->hashName();
  Storage::disk(config('constant.storage_type'))->putFileAs($folder,$file,$fileName);
  return $fileName;
}

function sanitize($line){
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $line); // attempt to translate similar characters
   $clean = preg_replace('/[^\w]/', '', $clean); // drop anything but ASCII
   return $clean;
}
