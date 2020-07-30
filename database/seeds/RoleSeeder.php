<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Role::create(['name' => 'admin']);
         Role::create(['name' => 'instractor']);
         Role::create(['name' => 'partner']);
         Role::create(['name' => 'student']);

        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'create user']);

        Permission::create(['name' => 'edit course']);
        Permission::create(['name' => 'delete course']);
        Permission::create(['name' => 'create course']);

        Permission::create(['name' => 'edit grade']);
        Permission::create(['name' => 'delete grade']);
        Permission::create(['name' => 'create grade']);

        Permission::create(['name' => 'edit material']);
        Permission::create(['name' => 'delete material']);
        Permission::create(['name' => 'create material']);

        Permission::create(['name' => 'edit topic']);
        Permission::create(['name' => 'delete topic']);
        Permission::create(['name' => 'create topic']);




//        factory( App\Role::class, 4)->create();

    }
}
