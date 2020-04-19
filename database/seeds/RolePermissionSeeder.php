<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
        // Cleanup Role & Permission
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Permission::truncate();
        Role::truncate();

        // Role Building
        $roleBuilding = Role::create(['name' => 'Building']);
        // Permissions
        $buildingView = Permission::create(['name' => 'View Building']);
        $buildingCreate = Permission::create(['name' => 'Create Building']);
        $buildingModify = Permission::create(['name' => 'Modify Building']);
        $buildingDelete = Permission::create(['name' => 'Delete Building']);

        // Role Finance
        $roleFinance = Role::create(['name' => 'Finance']);
        // Permissions
        $financeView = Permission::create(['name' => 'View Finance']);
        $financeCreate = Permission::create(['name' => 'Create Finance']);
        $financeModify = Permission::create(['name' => 'Modify Finance']);
        $financeDelete = Permission::create(['name' => 'Delete Finance']);

        // Role Article
        $roleArticle = Role::create(['name' => 'Article']);
        // Permissions
        $articleView = Permission::create(['name' => 'View Article']);
        $articleCreate = Permission::create(['name' => 'Create Article']);
        $articleModify = Permission::create(['name' => 'Modify Article']);
        $articleDelete = Permission::create(['name' => 'Delete Article']);

        $userView = Permission::create(['name' => 'View User']);
        $userCreate = Permission::create(['name' => 'Create User']);
        $userModify = Permission::create(['name' => 'Modify User']);
        $userDelete = Permission::create(['name' => 'Delete User']);

        $buildingPermission = [
            $buildingView,
            $buildingCreate,
            $buildingModify,
            $buildingDelete
        ];

        $articlePermission = [
            $articleView,
            $articleCreate,
            $articleModify,
            $articleDelete
        ];

        $financePermission = [
            $financeView,
            $financeCreate,
            $financeModify,
            $financeDelete,
        ];

        $adminPermission = [
            $buildingView,
            $buildingCreate,
            $buildingModify,
            $buildingDelete,
            $articleView,
            $articleCreate,
            $articleModify,
            $articleDelete,
            $financeView,
            $financeCreate,
            $financeModify,
            $financeDelete,
            $userView,
            $userCreate,
            $userModify,
            $userDelete
        ];

        
        $roleAdmin = Role::create(['name' => 'Administrator']);

        $roleBuilding->syncPermissions($buildingPermission);
        $roleArticle->syncPermissions($articlePermission);
        $roleFinance->syncPermissions($financePermission);
        $roleAdmin->syncPermissions($adminPermission);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
