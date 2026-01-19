<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\Crud;
use App\Imports\UserImport;
use App\Models\Components\Buttons;
use App\Models\Components\Inputs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PHPUnit\Exception;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class MasterKelasController extends Controller
{
    public function __construct()
    {
        // $this->middleware('checkUserRoleOrPermission:user-read')->only(['getDefaultColumn', 'getAllData', 'index', 'show']);
        // $this->middleware('checkUserRoleOrPermission:user-delete')->only(['destroy']);
        // $this->middleware('checkUserRoleOrPermission:user-create')->only(['store', 'import']);
        // $this->middleware('checkUserRoleOrPermission:user-update')->only(['update', 'updatePermission']);
    }

    public function index(Request $request)
    {
        return view('admin.users.dataUser');
    }

    public function getDefaultColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no', 'searchable' => false, 'orderable' => false],
            ['data' => 'username', 'name' => 'username', 'searchable' => true, 'orderable' => true],
            ['data' => 'role', 'name' => 'role', 'searchable' => true, 'orderable' => true],
            ['data' => 'name', 'name' => 'nama', 'searchable' => false, 'orderable' => true],
            ['data' => 'btn_detail', 'name' => 'detail', 'searchable' => false, 'orderable' => false],
            ['data' => 'btn_edit', 'name' => 'edit', 'searchable' => false, 'orderable' => false],
            ['data' => 'btn_save', 'name' => '', 'searchable' => false, 'orderable' => false],
            ['data' => 'btn_cancel', 'name' => '', 'searchable' => false, 'orderable' => false],
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
            $columnName = 'users.created_at';

            $columnSortOrder = 'desc';
        }

        // Total records
        $totalRecords = User::select('count(*) as allcount')->where('users.is_active', '=', 1)->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('users.username', 'like', '%' . $searchValue . '%')->where('users.is_active', '=', 1)->count();

        // Fetch records
        $records = User::orderBy($columnName, $columnSortOrder)
            ->join('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->where('users.name', 'like', '%' . $searchValue . '%')
            ->where('users.is_active', '=', 1)
            ->where('users.id', '!=', Auth::id())
            ->select('users.id', 'users.name', 'users.username', 'roles.name as role')
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
            $data_arr[] = array(
                "no" => $numberStart,
                "name" => "<div class='' id='view-name-" . $record->item_id . "'>" . $record->name . "</div>" . Inputs::Input($record->item_id, "name", $record->name),
                "username" => "<div class='' id='view-username-" . $record->item_id . "'>" . $record->username . "</div>" . Inputs::Input($record->item_id, "username", $record->username),
                "role" => ($record->role ?: ' - '),
                'id' => $record->item_id,
                'btn_detail' => '<a href="' . route('admin.users.show', $record->item_id) . '" class="btn btn-primary"><i class="ti ti-"></i>Detail</a>',
                'btn_edit' => Buttons::BtnEdit($record->item_id),
                'btn_save' => Buttons::BtnSave($record->item_id),
                'btn_cancel' => Buttons::BtnCancel($record->item_id),
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

    public function show($id, Request $request)
    {
        $id = Crypt::decrypt($id);
        $data = [];
        $anggota = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->select(
                'users.username',
                'users.id',
                'users.name',
                'users.email',
                'roles.name as role',
            )->where('users.id', $id)
            ->first();

        $anggota->item_id = Crypt::encrypt($anggota->id);
        unset($anggota->id);

        $roles = Role::all();

        $data['anggota'] = $anggota;
        $data['roles'] = $roles;

        if ($anggota) {
            return view('admin.users.showUser', $data);
        } else {
            return redirect()->route('admin.users.index');
        }
    }

    public function indexApi()
    {
        $filters = [];

        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }

        $eb = ['btn_page_detail'];

        $dataQueries = User::where(function ($query) use ($orThose) {
            $query->where('username', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('name', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('email', 'LIKE', '%' . $orThose . '%');
        })
            ->where('id', '!=', Auth::id())
            ->select(
                'id',
                'email',
                'username',
                'name',
            )
            ->orderBy($orderBy, $orderState)
            ->paginate(10);

        $data_columns = ['username', 'name', 'email'];


        $datas['data_queries'] = $dataQueries;
        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $data_columns;
        return $datas;
    }

    public function messages()
    {
        return [
            'email.required' => 'email user harus diisi',
            'username.required' => 'username admin harus diisi',
            'name.required' => 'Nama admin harus diisi',
            'password.required' => 'Password harus diisi',
            'name.numeric' => 'Nama Harus angka harus diisi',
        ];
    }

    public function store(Request $request)
    {
        //        dd($request);
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:50', 'unique:users'],
            'username' => ['string', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'name' => ['required', 'string', 'min:6'],
            'role' => ['required'],
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['message' => 'Silahkan periksa form anda', 'error' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            // dd($request->username);
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                "pangkat" => $request->pangkat,
                "nip" => $request->nip,
                "jabatan" => $request->jabatan,
                "agama" => $request->agama,
                "jenis_kelamin" => $request->jenis_kelamin,
                "unit_esl_3" => $request->unit_esl_3,
                "unit_esl_4" => $request->unit_esl_4,
                "pendidikan_terakhir" => $request->pendidikan_terakhir,
                "tamat_jabatan" => $request->tamat_jabatan,
                "tamat_pangkat" => $request->tamat_pangkat,
                "nama_kantor" => $request->nama_kantor,
                "pendidikan" => $request->pendidikan,
                "generasi" => $request->generasi,
                "kategori_umur" => $request->kategori_umur,
                "golongan" => $request->golongan,
                "tanggal_lahir" => $request->tanggal_lahir,
                "jenis_jabatan" => $request->jenis_jabatan,
                "tamat_kpg" => $request->tamat_kpg,
                "homebase" => $request->homebase,
                "status_menikah" => $request->status_menikah,
                "masa_kerja" => $request->masa_kerja,
            ]);
            $user->assignRole($request->role);

            DB::commit();
            return response()->json(['message' => 'Sukses, data Admin telah disimpan '], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal, data Admin gagal disimpan', 'error' => $e], 422);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'fileImport' => ['required', 'mimes:xls,xlsx', 'max:2048']
        ], $this->messages());

        $file = $request->fileImport;

        try {
            DB::beginTransaction();

            Excel::import(new UserImport, $file);

            DB::commit();
            return response()->json(['message' => 'Sukses, data Anggota telah diimport, silahkan periksa kembali'], 200);
        } catch (ValidationException $excel) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal, import gagal', 'error' => $excel], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $encryptedId = $id;
        $id = Crypt::decrypt($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:30'],
            'username' => ['required', 'regex:/^\S*$/'],
        ], $this->messages());
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Silahkan periksa form anda',
                    'error' => $validator->errors(),
                    'id' => $encryptedId
                ],
                422
            );
        }

        $anggota = User::where('id', $id)
            ->first();

        try {
            DB::beginTransaction();

            $anggota->update([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                "pangkat" => $request->pangkat,
                "nip" => $request->nip,
                "jabatan" => $request->jabatan,
                "agama" => $request->agama,
                "jenis_kelamin" => $request->jenis_kelamin,
                "unit_esl_3" => $request->unit_esl_3,
                "unit_esl_4" => $request->unit_esl_4,
                "tempat_lahir" => $request->tempat_lahir,
                "pendidikan_terakhir" => $request->pendidikan_terakhir,
                "tamat_jabatan" => $request->tamat_jabatan,
                "tamat_pangkat" => $request->tamat_pangkat,
                "nama_kantor" => $request->nama_kantor,
                "pendidikan" => $request->pendidikan,
                "generasi" => $request->generasi,
                "kategori_umur" => $request->kategori_umur,
                "golongan" => $request->golongan,
                "tanggal_lahir" => $request->tanggal_lahir,
                "jenis_jabatan" => $request->jenis_jabatan,
                "tamat_kpg" => $request->tamat_kpg,
                "homebase" => $request->homebase,
                "status_menikah" => $request->status_menikah,
                "masa_kerja" => $request->masa_kerja,
            ]);

            $anggota->assignRole($request->role);

            DB::commit();
            return response()->json(['message' => 'Sukses, data Admin telah disimpan'], 200);
        } catch (ExceptioN $e) {
            DB::rollBack();

            return response()->json(['message' => 'Gagal, data Admin gagal disimpan', 'error' => $e], 422);
        }
    }


    public function destroy($id)
    {
        $encryptedId = $id;
        $id = Crypt::decrypt($id);

        try {
            DB::beginTransaction();

            User::where('id', $id)->delete();

            DB::commit();
            return response()->json(['message' => 'Sukses, data anggota telah dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal, data anggota tidak dapat dihapus', 'error' => $e], 422);
        }
    }

    public function changePassword($id, Request $request)
    {
        $encryptedId = $id;
        $id = Crypt::decrypt($id);

        $validator = Validator::make($request->all(), [
            'old_password' => ['string'],
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['message' => 'Silahkan periksa form anda', 'error' => $validator->errors()], 422);
        }

        $user = User::where('id', '=', $id)->first();

        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {

                $validator = Validator::make($request->all(), [
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                ], $this->messages());

                if ($validator->fails()) {
                    return response()->json(['message' => 'Silahkan periksa form anda', 'error' => $validator->errors()], 422);
                }

                try {
                    DB::beginTransaction();

                    $newPassword = $request->password;

                    $user->update([
                        'password' => bcrypt($newPassword),
                    ]);

                    DB::commit();
                    return response()->json(['message' => 'Sukses, password telah diganti']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['message' => 'gagal merubah password user', 'error' => $e], 422);
                }
            } else {
                return response()->json(['message' => 'Gagal, password lama salah'], 422);
            }
        } else {
            return response()->json(['message' => 'Gagal, user tidak ditemukan'], 422);
        }
    }

    public function resetPassword($id, Request $request)
    {
        $encryptedId = $id;
        $id = Crypt::decrypt($id);

        $user = User::where('id', '=', $id)->first();

        if ($user) {
            try {
                DB::beginTransaction();

                $user->update([
                    'password' => bcrypt($user->username),
                ]);

                DB::commit();
                return response()->json(['message' => 'Sukses, password telah direset']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'Gagal, password tidak dapat direset', 'error' => $e], 422);
            }
        } else {
            return response()->json(['message' => 'Gagal, user tidak ditemukan'], 422);
        }
    }
}
