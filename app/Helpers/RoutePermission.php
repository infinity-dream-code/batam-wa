<?php

namespace App\Helpers;

use Auth;
use Illuminate\Support\Facades\Validator;

class RoutePermission
{
    public function permissionRole($userPermission)
    {
        $permission = [
            'read' => ['show', 'index', 'listapi'],
            'create' => ['store'],
            'update' => ['update', 'edit'],
            'delete' => ['destroy'],
            'excel' => ['export_excel', 'import_excel'],
            'pdf' => ['export_pdf', 'import_pdf']
        ];

        $arr = array_map(function ($item) {
            $parts = explode('-', $item);
            return ($parts);
        }, $userPermission);

        $filterPer = $this->filterPermissions($arr, $permission);
        $arrLast = [];
        foreach ($filterPer as $value) {
            foreach ($value[1] as $mboh) {
                $arrLast[] = $value[0] . "." . $mboh;
            }
        }

        return $arrLast;
    }

    function filterPermissions($permissions, $permissionMapping)
    {
        $filteredPermissions = [];

        foreach ($permissions as $permission) {
            $key = $permission[0];
            $action = $permission[1];

            if (isset($permissionMapping[$action])) {
                $filteredPermissions[] = [$key, $permissionMapping[$action]];
            }
        }

        return $filteredPermissions;
    }
}
