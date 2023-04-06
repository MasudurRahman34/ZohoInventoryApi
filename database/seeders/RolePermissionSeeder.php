<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PermissionGroup = [

            ['group' => 'Role', 'description' => 'role access controll', 'default' => 'yes', 'status' => 'active'],
            ['group' => 'permission', 'description' => 'permission access controll', 'default' => 'yes', 'status' => 'active'],
            ['group' => 'Purchase', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            ['group' => 'Account', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            ['group' => 'Setting', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],

        ];

        $permission = [
            ['name' => 'create role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'type' => 'create', 'default' => 'yes', 'status' => 'active'],
            ['name' => 'view role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'type' => 'view', 'default' => 'yes', 'status' => 'active'],
            ['name' => 'edit role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'type' => 'edit', 'default' => 'yes', 'status' => 'active'],
            ['name' => 'delete role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'type' => 'delete', 'default' => 'yes', 'status' => 'active'],

        ];



        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        PermissionGroup::truncate();
        PermissionGroup::insert($PermissionGroup);

        DB::table('permissions')->delete();
        Permission::insert($permission);

        DB::table('roles')->delete();
        Role::create(['name' => 'Admin', 'guard_name' => 'api', 'default' => 'yes', 'status' => 'active'])->givePermissionTo(['create role', 'view role', 'edit role', 'delete role']);
    }
}
