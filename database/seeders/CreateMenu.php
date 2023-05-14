<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
class CreateMenu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus =[
              ['name' => 'home','parent_id' => null],
              ['name' => 'Copmany','parent_id' => null],
              ['name' => 'Carrer','parent_id' => 2],
              ['name' => 'about us','parent_id' => 2],
              ['name' => 'service','parent_id' => null],
              ['name' => 'service 1','parent_id' => 5],
              ['name' => 'service 2','parent_id' => 5],
              ['name' => 'service 3','parent_id' => 5],
              ['name' => 'portfolio service ','parent_id' => 5],
              ['name' => 'portfolio service 1','parent_id' => 9],
              ['name' => 'portfolio service 2','parent_id' => 9],
              ['name' => 'portfolio service 3','parent_id' => 9]
        ];
        
        Menu::insert($menus);
    }
}
