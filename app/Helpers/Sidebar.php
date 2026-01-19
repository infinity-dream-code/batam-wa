<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Sidebar
{

  public function generate()
  {
    $userRole = Auth::user()->roles->toArray();
    $idRole = $userRole[0]['id'];

    $permissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
      ->where('role_has_permissions.role_id', $idRole)
      ->pluck('name')
      ->toArray();

    // dd($permissions);
    return $permissions;
  }
}
