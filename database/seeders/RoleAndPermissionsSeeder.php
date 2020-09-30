<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' =>  'Administrador']);
        $role2 = Role::create(['name' => 'Semilleros general']);
        $role3 = Role::create(['name' => 'Semilleros especifico']);
        $role4 = Role::create(['name' => 'Estudiante']);


        $permission =  Permission::create(['name' => 'create groups']);
        $permission2 = Permission::create(['name' => 'create teachers']);
        $permission3 = Permission::create(['name' => 'create departments']);
        $permission4 = Permission::create(['name' => 'create programs']);
        $role->syncPermissions([$permission,$permission2,$permission3,$permission4]);

        $permission_specific1 = Permission::create(['name' => 'manage seedlings']);
        $permission_specific2 = Permission::create(['name' => 'add collaborators']);
        $role3->syncPermissions([$permission_specific1,$permission_specific2]);

        $permission_general1 = Permission::create(['name' => 'add seedlings']);
        $permission_general2 = Permission::create(['name' => 'asociate teachers']);
        $role2->syncPermissions([$permission_general1,$permission_general2]);

        $permission_student = Permission::create(['name' => 'preinscription']);
        $role4->givePermissionTo($permission_student);
    }
}
