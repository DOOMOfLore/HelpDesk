<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::insert([
            ['name' => 'Superadmin', 'guard_name' => 'web'],
            ['name' => 'Admin', 'guard_name' => 'web'],
        ]);

        $permission = Permission::get();
        Role::where('name','Superadmin')->first()->givePermissionTo($permission->pluck('name'));
        // Role::where('name','Admin')->first()->givePermissionTo(['view mitra']);

        User::where('username','superadmin')->first()->assignRole('Superadmin');
        // User::where('username','admin')->first()->assignRole('Admin');
    }
}



