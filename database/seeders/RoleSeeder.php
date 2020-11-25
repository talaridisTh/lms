<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'instructor']);
        Role::create(['name' => 'partner']);
        Role::create(['name' => 'student']);
        Role::create(['name' => 'Υδρογειος']);
        Role::create(['name' => 'guest']);
        Role::create(['name' => 'trial user']);
        Role::create(['name' => 'super-admin']);


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
    }

}
