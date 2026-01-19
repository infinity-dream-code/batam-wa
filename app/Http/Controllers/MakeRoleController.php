<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MakeRoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function makeRole()
    {
        // Permission::create(['name' => 'kontak-read']);
        // Permission::create(['name' => 'kontak-create']);
        // Permission::create(['name' => 'kontak-update']);
        // Permission::create(['name' => 'kontak-delete']);

        // Permission::create(['name' => 'faq-read']);
        // Permission::create(['name' => 'faq-create']);
        // Permission::create(['name' => 'faq-update']);
        // Permission::create(['name' => 'faq-delete']);

        Permission::create(['name' => 'galery-read']);
        // Permission::create(['name' => 'galery-create']);
        // Permission::create(['name' => 'galery-update']);
        // Permission::create(['name' => 'galery-delete']);


        $role = Role::where('name', 'admin')->first();
        // $role->givePermissionTo('kontak-read');
        // $role->givePermissionTo('kontak-update');
        // $role->givePermissionTo('kontak-create');
        // $role->givePermissionTo('kontak-delete');

        // $role->givePermissionTo('faq-read');
        // $role->givePermissionTo('faq-update');
        // $role->givePermissionTo('faq-create');
        // $role->givePermissionTo('faq-delete');

        $role->givePermissionTo('galery-read');
        // $role->givePermissionTo('faq-update');
        // $role->givePermissionTo('faq-create');
        // $role->givePermissionTo('faq-delete');

        return "atah";
    }
}
