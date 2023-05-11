<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class CreatePermission extends Seeder
{
  /**
  * Run the database seeds.
  */
  public function run(): void
  {
    $permissions = config('constant.permissions');
    if (!blank($permissions)) {
      foreach ($permissions as $permission) {
        Permission::updateOrCreate(['name' => $permission], ['name' => $permission]);
      }
    }
  }
}