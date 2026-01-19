<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkUserRoleOrPermission:role-read')->only(['getDefaultColumn', 'getAllData', 'index', 'show']);
        $this->middleware('checkUserRoleOrPermission:role-update')->only(['update', 'updatePermission']);
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Permission harus diisi',
        ];
    }

    public function getDefaultColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no', 'searchable' => false, 'orderable' => false],
            ['data' => 'name', 'name' => 'nama', 'searchable' => true, 'orderable' => true],
            ['data' => 'status', 'name' => 'status', 'searchable' => false, 'orderable' => false],
        ];
    }

    public function getAllData($id, Request $request)
    {
        $id = Crypt::decrypt($id);
        $role = Role::find($id);
//        dd($id);
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        if (!$columnName || $columnName == 'no') {
            $columnName = 'name';

            $columnSortOrder = 'desc';
        }

        // Total records
        $totalRecords = Permission::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Permission::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Permission::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('id', 'name')
            ->skip($start)
            ->take($rowperpage)
            ->get()
            ->map(function ($item) {
                $item->item_id = Crypt::encrypt($item->id);
                unset($item->id);
                return $item;
            });

        $data_arr = array();

        $numberStart = $start + 1;
        foreach ($records as $record) {
            $jsonData = json_encode($record);
            $encodedData = htmlspecialchars($jsonData, ENT_QUOTES, 'UTF-8');

            $permission = $role->hasPermissionTo($record->name);
            if ($permission) {
                $status = '
                <label class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" checked="">
                            </label>
                ';
            } else {
                $status = '
                <label class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" >
                            </label>
                ';
            }

            $data_arr[] = array(
                "no" => $numberStart,
                "name" => $record->name,
                'id' => $record->item_id,
                'status' => $status,
            );

            $numberStart++;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data_arr,
        );

        return response()->json($response);
    }

    public function updatePermission($id, Request $request)
    {
        try {
            $id = Crypt::decrypt($id);
            $roles = Role::where('id', $id)->first();

            if (!$roles) {
                return response()->json(['message' => 'Gagal, Role tidak ditemukan'], 422);
            } else {
                $usersWithRole = $roles->users()->count();

                if ($usersWithRole > 0) {
                    return response()->json(['message' => 'Gagal, Role "' . $roles->name . '" dipakai!'], 422);
                } else {
                    try {
                        DB::beginTransaction();
//                        $roles->delete();
                        DB::commit();

                        return response()->json(['message' => 'Sukses, Role ' . $roles->name . ' telah telah dihapus']);
                    } catch (Exception $e) {
                        DB::rollBack();
                        return response()->json(['message' => 'Gagal, Role ' . $roles->name . ' gagal dihapus', 'error' => $e], 422);
                    }
                }

            }
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Gagal, Role tidak ditemukan'], 422);
        }
    }
}
