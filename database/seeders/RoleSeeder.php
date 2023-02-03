<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $authorities = config('permission.authorities');
        $listPermission = [];
        $superAdminPermission = [];
        $editorPermission = [];
        foreach ($authorities as $label => $permissions) {
            foreach ($permissions as $permission) {
                $listPermission[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),

                ];
                // hak akses super admin
                $superAdminPermission[] = $permission;

                // editor
                if (in_array($label, ['artikel','portfolio','kategori_artikel','kategori_portfolio'])) {
                    $editorPermission[] = $permission;
                }
            }
        }

        // Insert permission
        Permission::insert($listPermission);

        // Insert nama Roles Super Admin
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // Insert nama Roles Editor
        $editor = Role::create([
            'name' => 'Admin Olshop',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // pemberian hak akses
        $superAdmin->givePermissionTo($superAdminPermission);
        $editor->givePermissionTo($editorPermission);

        //assign Roles
        $userSuperAdmin = User::find(1)->assignRole("Super Admin");
        $userSuperAdmin = User::find(3)->assignRole("Super Admin");
        $userEditor = User::find(2)->assignRole("Admin Olshop");
    }
}
