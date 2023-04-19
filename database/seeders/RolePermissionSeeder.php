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
            ['group' => 'User', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            ['group' => 'Supplier', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            ['group' => 'Customer', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            ['group' => 'Purchase', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            // ['group' => 'Account', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],
            // ['group' => 'Setting', 'description' => NULL, 'default' => 'yes', 'status' => 'active'],

        ];

        $permission = [

            //role
            ['name' => 'create role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'title' => 'Role Create', 'description'=>'Whether user can create Role or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'view role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'title' => 'Role View', 'description'=>'Whether user can view full list of role or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'edit role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'title' => 'Role Edit', 'description'=>'Whether user can update role or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'delete role', 'guard_name' => 'api', 'permission_groups_id' => 1, 'title' => 'Role Delete', 'description'=>'Whether user can delete  role or not','default' => 'yes', 'status' => 'active'],

            //permisison

            ['name' => 'create permission', 'guard_name' => 'api', 'permission_groups_id' => 2, 'title' => 'Permission Create', 'description'=>'Whether user can create permission or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'view permission', 'guard_name' => 'api', 'permission_groups_id' => 2, 'title' => 'Permission View', 'description'=>'Whether user can view full list of permission or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'edit permission', 'guard_name' => 'api', 'permission_groups_id' => 2, 'title' => 'Permission Edit', 'description'=>'Whether user can update permission or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'delete permission', 'guard_name' => 'api', 'permission_groups_id' => 2, 'title' => 'Permission Delete', 'description'=>'Whether user can delete  permission or not','default' => 'yes', 'status' => 'active'],


            //user
            ['name' => 'create user', 'guard_name' => 'api', 'permission_groups_id' => 3, 'title' => 'User Create', 'description'=>'Whether user can create user or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'edit user', 'guard_name' => 'api', 'permission_groups_id' => 3, 'title' => 'User Edit', 'description'=>'Whether user can update user or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'delete user', 'guard_name' => 'api', 'permission_groups_id' => 3, 'title' => 'User Delete', 'description'=>'Whether user can delete  user or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'view user', 'guard_name' => 'api', 'permission_groups_id' => 3, 'title' => 'user View', 'description'=>'Whether user can view full list of user or not','default' => 'yes', 'status' => 'active'],

            //Supplier
            ['name' => 'create supplier', 'guard_name' => 'api', 'permission_groups_id' => 4, 'title' => 'Supplier Create', 'description'=>'Whether user can create supplier or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'edit supplier', 'guard_name' => 'api', 'permission_groups_id' => 4, 'title' => 'Supplier Edit', 'description'=>'Whether user can update supplier or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'delete supplier', 'guard_name' => 'api', 'permission_groups_id' => 4, 'title' => 'Supplier Delete', 'description'=>'Whether user can delete  supplier or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'view supplier', 'guard_name' => 'api', 'permission_groups_id' => 4, 'title' => 'Supplier View', 'description'=>'Whether user can view full list of supplier or not','default' => 'yes', 'status' => 'active'],

            //Customer
            ['name' => 'create customer', 'guard_name' => 'api', 'permission_groups_id' => 5, 'title' => 'Customer Create', 'description'=>'Whether user can create customer or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'edit customer', 'guard_name' => 'api', 'permission_groups_id' => 5, 'title' => 'Customer Edit', 'description'=>'Whether user can update customer or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'delete customer', 'guard_name' => 'api', 'permission_groups_id' => 5, 'title' => 'Customer Delete', 'description'=>'Whether user can delete  customer or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'view customer', 'guard_name' => 'api', 'permission_groups_id' => 5, 'title' => 'Customer View', 'description'=>'Whether user can view full list of customer or not','default' => 'yes', 'status' => 'active'],

            //purchase
            ['name' => 'create purchase', 'guard_name' => 'api', 'permission_groups_id' => 6, 'title' => 'Purchase Create', 'description'=>'Whether user can create purchase or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'edit purchase', 'guard_name' => 'api', 'permission_groups_id' => 6, 'title' => 'Purchase Edit', 'description'=>'Whether user can update purchase or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'delete purchase', 'guard_name' => 'api', 'permission_groups_id' => 6, 'title' => 'Purchase Delete', 'description'=>'Whether user can delete  purchase or not','default' => 'yes', 'status' => 'active'],
            ['name' => 'view purchase', 'guard_name' => 'api', 'permission_groups_id' => 6, 'title' => 'Purchase View', 'description'=>'Whether user can view full list of purchase or not','default' => 'yes', 'status' => 'active'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permission_groups')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        PermissionGroup::insert($PermissionGroup);
        Permission::insert($permission);

        $getAllPermissionsName= Permission::all()->pluck('name');
        Role::create(['name' => 'Admin', 'guard_name' => 'api', 'default' => 'yes', 'status' => 'active'])
        ->givePermissionTo($getAllPermissionsName);
    }
}
