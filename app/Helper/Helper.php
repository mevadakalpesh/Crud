<?php
use Illuminate\Support\Facades\Storage;


function storeFile($folder,$file,$prefix){
  $fileName = $prefix.'_'.$file->hashName();
  Storage::disk(config('constant.storage_type'))->putFileAs($folder,$file,$fileName);
  return $fileName;
}