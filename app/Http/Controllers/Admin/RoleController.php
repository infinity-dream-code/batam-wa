<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\ViewComponent\Button;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkUserRoleOrPermission:role-read')->only(['getDefaultColumn', 'getAllData', 'index', 'show']);
        $this->middleware('checkUserRoleOrPermission:role-delete')->only(['destroy']);
        $this->middleware('checkUserRoleOrPermission:role-create')->only(['store']);
        $this->middleware('checkUserRoleOrPermission:role-update')->only(['update', 'updatePermission']);
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Role harus diisi',
        ];
    }

    public function getDefaultColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no', 'searchable' => false, 'orderable' => false],
            ['data' => 'name', 'name' => 'nama', 'searchable' => true, 'orderable' => true],
            ['data' => 'permissions', 'name' => 'ijin', 'searchable' => false, 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false, 'orderable' => true],
            ['data' => 'updated_at', 'name' => 'updated_at', 'searchable' => false, 'orderable' => true],
            ['data' => 'btn_detail', 'name' => 'detail', 'searchable' => false, 'orderable' => false],
            ['data' => 'btn_delete', 'name' => 'detail', 'searchable' => false, 'orderable' => false],
        ];
    }

    public function getAllData(Request $request)
    {
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
            $columnName = 'created_at';

            $columnSortOrder = 'desc';
        }

        // Total records
        $totalRecords = Role::select('count(*) as allcount')->where('name', '!=', 'super-admin')->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->where('name', '!=', 'super-admin')->count();

        // Fetch records
        $records = Role::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->where('name', '!=', 'super-admin')
            ->select('id', 'name', 'created_at', 'updated_at')
            ->skip($start)
            ->take($rowperpage)
            ->get()
            ->map(function ($item) {
                $permissions = $item->permissions->pluck('name')->toArray();
                $item->permissions = $permissions;

                $item->item_id = Crypt::encrypt($item->id);
                unset($item->id);
                return $item;
            });

        $data_arr = array();

        $numberStart = $start + 1;
        foreach ($records as $record) {
            $jsonData = json_encode($record);
            $encodedData = htmlspecialchars($jsonData, ENT_QUOTES, 'UTF-8');
            $detailRoute = route('admin.roles.show', $record->item_id);

            $data_arr[] = array(
                "no" => $numberStart,
                "name" => $record->name,
                "created_at" => ($record->created_at->format('d F Y, H:i:s') ?: ' - '),
                "updated_at" => ($record->updated_at->format('d F Y, H:i:s') ?: ' - '),
                'id' => $record->item_id,
                'permissions' => $record->permissions,
                'btn_detail' => Button::btnPageShow($detailRoute, 'Detail'),
                'btn_delete' => '<button data-val="' . $encodedData . '" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-destroy"<i class="ti ti-trash"></i>&nbsp;Hapus</button>',
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

    public function index()
    {
        $data = [];

        $roles = Role::all();

        $data['roles'] = $roles;

        return view('admin.role.index', $data);
    }

    public function show($id)
    {
        $data = [];
        try {
            $idEncrypt = $id;

            $id = Crypt::decrypt($id);
            $roles = Role::where('id', $id)->first();

            if (!$roles) {
                return response()->json(['message' => 'Gagal, Role tidak ditemukan'], 422);
            } else {
                $allPermissions = Permission::all();
                $encryptedId = Crypt::encrypt($roles->id);
                $data['roles'] = $roles;
                $data['permissions'] = $allPermissions;
                $data['encryptedId'] = $encryptedId;
                $data['id'] = $idEncrypt;

                return view('admin.role.show', $data);
            }
        } catch (DecryptException $e) {
            return redirect()->route('admin.roles.index')->with('alert', 'errorAlert("Role tidak ditemukan")');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['message' => 'Silahkan periksa form anda', 'error' => $validator->errors()], 422);
        } else {

            $existingRole = Role::where('name', $request->name)->first();

            if (!$existingRole) {
                try {
                    DB::beginTransaction();
                    $roles = Role::create(['name' => $request->name]);
                    DB::commit();

                    return response()->json(['message' => 'Sukses, Role ' . $roles->name . ' telah telah dibuat']);
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['message' => 'Gagal, Role ' . $request->name . ' gagal disimpan', 'error' => $e], 422);
                }
            } else {
                return response()->json(['message' => 'Gagal, Role ' . $request->name . ' sudah ada'], 422);
            }
        }
    }

    public function destroy($id, Request $request)
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
                        $roles->delete();
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

    public function update($id, Request $request)
    {
        $requestPermission = array_slice(array_keys($request->all()), 2);

        try {
            $idEncrypt = $id;
            $id = Crypt::decrypt($id);

            $roles = Role::where('id', $id)->first();

            if (!$roles) {
                return response()->json(['message' => 'Gagal, Role tidak ditemukan'], 422);
            } else {

                $roles->syncPermissions([$requestPermission]);

                return redirect()->route('admin.roles.show', $idEncrypt)->with('alert', 'successAlert("Role berhasil di ubah")');
            }
        } catch (DecryptException $e) {
            return redirect()->route('admin.roles.show', $idEncrypt)->with('alert', 'errorAlert("Gagal, Role tidak ditemukan")');
        }
    }
}
