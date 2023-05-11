<?php 
return [
  'storage_path' => env('STORAGE_PATH','http://localhost/'),
  'default_image' => env('STORAGE_PATH','http://localhost/').'defualt_image.png',
  'storage_type' => env('STORAGE_TYPE','public'),
  'permissions' => [
    'product-read',
    'product-write',
    'file-read',
    'file-write'
  ]
];
?>