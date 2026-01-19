<?php

namespace App\Helpers;

use App\Models\Booking;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Constant
{

  public function permission($key)
  {
    $permissions = Auth::user()->role->permissions;
    $ret_col = [];
    if ($permissions) {
      $collection = collect(json_decode($permissions))->where('key', $key)->first();
      if ($collection) {
        $ret_col = $collection->access;
      }
    }

    return $ret_col;
  }

  public function permissionDb($key, $permissions)
  {
    $ret_col = [];
    if ($permissions) {
      $collection = collect(json_decode($permissions))->where('key', $key)->first();
      if ($collection) {
        $ret_col = $collection->access;
      }
    }

    return $ret_col;
  }

  public function permissionResource($key, $permissions)
  {
    $pdbs = $this->permissionDb($key, $permissions);
    $arr_permi = [];
    foreach ($pdbs as $key => $pdb) {
      if ($pdb == 'create') {
        $arr_permi[] = 'create';
        $arr_permi[] = 'store';
      } else if ($pdb == 'update') {
        $arr_permi[] = 'update';
        $arr_permi[] = 'edit';
      } else if ($pdb == 'read') {
        $arr_permi[] = 'index';
        $arr_permi[] = 'listapi';
      } else if ($pdb == 'delete') {
        $arr_permi[] = 'destroy';
      } else {
        $arr_permi[] = $pdb;
      }
    }

    return $arr_permi;
  }

  public function getPermissionFromRole()
  {
    $userRole = Auth::user()->roles->toArray();
    $idRole = $userRole[0]['id'];
    $permissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
      ->where('role_has_permissions.role_id', $idRole)
      ->pluck('name')
      ->toArray();

    return $permissions;
  }
}
