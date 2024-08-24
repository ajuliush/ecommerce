<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions
        $permissions = [
            'view permission',
            'edit permission',
            'delete permission',
            'create permission',

            'view role',
            'edit role',
            'delete role',
            'create role',

            'view user',
            'edit user',
            'delete user',
            'create user',

            'view article',
            'edit article',
            'delete article',
            'create article',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}