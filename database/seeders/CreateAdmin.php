<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
      
        $roleData = ['name' => 'SuperAdmin'];
        $role = Role::updateOrCreate($roleData,$roleData);
        $permissions = Permission::get()->pluck('id')->toArray();
        $role->syncPermissions($permissions);
        $adminData = [
          'name' => 'admin',
          'email' => 'admin@test.com',
          'password' => Hash::make(12345678)
        ];
        $admin = User::updateOrCreate(['email' => 'admin@test.com'],$adminData);
        $admin->assignRole($role);
    }
}
