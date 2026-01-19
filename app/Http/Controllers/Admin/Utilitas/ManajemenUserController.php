<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Http\Controllers\Controller;
use App\Models\LogModel;
use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_thn_aka;
use App\Models\MstThnAkaModel;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ManajemenUserController extends Controller
{
    public function __construct()
    {
        $this->title = 'Utilitas';
        $this->mainTitle = 'Manajemen User';
        $this->dataTitle = 'Manajemen User';
        $this->showTitle = 'Detail Manajemen User';
        $this->datasUrl = route('admin.manajemen-user.get-data');
        $this->detailDatasUrl = '';
        $this->columnsUrl = route('admin.manajemen-user.get-column');
    }

    public function index()
    {
        $angkatan = MstThnAkaModel::where('thn_aka', '!=', null)->get();
        $role = Role::all();
        $data['title'] = $this->title;
        $data['mainTitle'] = $this->mainTitle;
        $data['dataTitle'] = $this->dataTitle;
        $data['showTitle'] = $this->showTitle;
        $data['thn_aka'] = $angkatan;
        $data['datasUrl'] = $this->datasUrl;
        $data['columnsUrl'] = $this->columnsUrl;
        $data['modalLink'] = view('admin.utilitas.manajemen_user.modal', compact('role'));
        return view('admin.utilitas.manajemen_user.index', $data);
    }

    public function getColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no', 'className' => 'text-center'],
            ['data' => 'username', 'name' => 'Username', 'searchable' => true, 'orderable' => true],
            ['data' => 'nama', 'name' => 'Nama', 'searchable' => true, 'orderable' => true],
            ['data' => 'email', 'name' => 'Email', 'searchable' => true, 'orderable' => true],
            [
                'data' => 'edit',
                'name' => 'Edit',
                'columnType' => 'button',
                'className' => 'text-center',
                'button' => 'modal',
                'buttonText' => 'Edit',
                'buttonClass' => 'btn btn-sm btn-warning',
                'buttonLink' => '#modal-edit',
                'buttonIcon' => 'tf-icon ri-pencil-line me-2'
            ],
            [
                'data' => 'delete',
                'name' => 'Hapus',
                'columnType' => 'button',
                'className' => 'text-center',
                'button' => 'modal',
                'buttonText' => 'Hapus',
                'buttonClass' => 'btn btn-sm btn-danger',
                'buttonLink' => '#modal-delete',
                'buttonIcon' => 'tf-icon ri-delete-bin-5-line me-2'
            ],
        ];
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');

        $defaultColumn = 'users.created_at';
        $defaultOrder = 'desc';

        if ($request->has('order')) {
            $columnIndex_arr = $request->get('order');
            $columnIndex = $columnIndex_arr[0]['column'];
            $columnSortOrder = $columnIndex_arr[0]['dir'];
        } else {
            $columnIndex = $defaultColumn;
            $columnSortOrder = $defaultOrder;
        }

        $columnName = $columnName_arr[$columnIndex]['data'];
        $searchValue = $search_arr['value'];

        if (!$columnName || $columnName == 'no') {
            $columnName = $defaultColumn;
            $columnSortOrder = $defaultOrder;
        }
        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::whereAny(['username', 'name', 'email'], 'like', '%' . $searchValue . '%')
            ->whereNot('id', Auth::user()->id)->select('count(*) as allcount')->count();

        // Fetch records
        $records =  User::leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereAny(['users.username', 'users.name', 'users.email'], 'like', '%' . $searchValue . '%')
            ->whereNot('users.id', Auth::user()->id)
            ->orderBy($columnName, $columnSortOrder)
            ->select(
                'users.id as id',
                'roles.name as role',
                'users.email',
                'users.username',
                'users.password',
                'users.name as nama'

            )
            ->skip($start)
            ->take($rowperpage)
            ->get()
            ->map(function ($item, $index) {
                $item->no = $index + 1;
                $item->item_id = Crypt::encrypt($item->id);
                $item->edit = true;
                $item->delete = true;
                unset($item->id);
                return $item;
            })->toArray();

        // dd($records);
        $response = array(
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecordswithFilter,
            'data' => $records,
        );
        return response()->json($response);
    }

    public function messages()
    {
        return [
            'email.required' => 'email user harus diisi',
            'username.required' => 'username admin harus diisi',
            'name.required' => 'Nama admin harus diisi',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password tidak sama',

        ];
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'username' => [
                'string',
                'max:255',
                'unique:users',
                'regex:/^[a-z0-9]+$/i', // Hanya huruf kecil dan angka diizinkan
                function ($attribute, $value, $fail) {
                    if (preg_match('/\s/', $value)) {
                        $fail($attribute . ' tidak boleh mengandung spasi.');
                    }
                    if (preg_match('/[^a-z0-9]/i', $value)) {
                        $fail($attribute . ' hanya boleh mengandung huruf dan angka.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // 'role' => ['required'],
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['message' => 'Silahkan periksa form anda', 'error' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            // dd($request->username);
            $user = User::create([
                'username' => $request->username,
                'name' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $log = new LogModel();
            $log->user_id =  auth()->check() ? auth()->user()->id : null;
            $log->menu =  'Manajemen User';
            $log->aksi =  'Buat User Baru ' . $request->nama;
            $log->client_info =  $request->server('HTTP_USER_AGENT');
            $log->target_id =  'Buat User ' . $request->nama;
            $log->ip_address =   $request->ip();
            $log->status =  "Berhasil Membuar User " . $request->nama;
            $log->save();
            $user->syncRoles('admin');

            DB::commit();
            return response()->json(['message' => 'Sukses, data Admin telah disimpan '], 200);
        } catch (Exception $e) {
            DB::rollBack();
            $log = new LogModel();
            $log->user_id =  auth()->check() ? auth()->user()->id : null;
            $log->menu =  'Manajemen User';
            $log->aksi =  'Gagal Membuat User Baru ' . $request->nama;
            $log->client_info =  $request->server('HTTP_USER_AGENT');
            $log->target_id =  'Gagal Membuat User ' . $request->nama;
            $log->ip_address =   $request->ip();
            $log->status =  "error " . $e->getMessage();
            $log->save();
            return response()->json(['message' => 'Gagal, data Admin gagal disimpan', 'error' => $e->getMessage()], 422);
        }
    }
    public function update($id, Request $request)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 422);
        }
        $rules = [
            'username' => [
                'string',
                'max:255',
                'unique:users,username,' . $decryptedId,
                'regex:/^[a-z0-9]+$/i', // Hanya huruf kecil dan angka diizinkan
                function ($attribute, $value, $fail) {
                    if (preg_match('/\s/', $value)) {
                        $fail($attribute . ' tidak boleh mengandung spasi.');
                    }
                    if (preg_match('/[^a-z0-9]/i', $value)) {
                        $fail($attribute . ' hanya boleh mengandung huruf dan angka.');
                    }
                },
            ],
            'email' => [
                'unique:users,email,' . $decryptedId,
            ],

        ];
        if ($request->password != null) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }
        $validator = Validator::make($request->all(), $rules, $this->messages());

        if ($validator->fails()) {
            return response()->json(['message' => 'Silahkan periksa form anda', 'error' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            // dd($request->username);
            $user = User::where('id', $decryptedId)->first();
            $user->username = $request->username;
            $user->name = $request->nama;
            $user->email = $request->email;
            if ($request->password) {
                $user->password =  bcrypt($request->password);
            }

            $user->save();
            // $user->syncRoles($request->role);

            if ($request->password) {
                $log = new LogModel();
                $log->user_id =  auth()->check() ? auth()->user()->id : null;
                $log->menu =  'Manajemen User';
                $log->aksi =  'Mengganti Password User ' . $request->nama;
                $log->client_info =  $request->server('HTTP_USER_AGENT');
                $log->target_id =  'Mengganti Password User ' . $request->nama;
                $log->ip_address =   $request->ip();
                $log->status =  "Berhasil Mengganti Password User " . $request->nama;
                $log->save();
            } else {
                $log = new LogModel();
                $log->user_id =  auth()->check() ? auth()->user()->id : null;
                $log->menu =  'Manajemen User';
                $log->aksi =  'Update Data User ' . $request->nama;
                $log->client_info =  $request->server('HTTP_USER_AGENT');
                $log->target_id =  'Update Data User ' . $request->nama;
                $log->ip_address =   $request->ip();
                $log->status =  "Berhasil Update Data User " . $request->nama;
                $log->save();
            }
            DB::commit();
            return response()->json(['message' => 'Sukses, data User telah disimpan '], 200);
        } catch (Exception $e) {
            DB::rollBack();
            $log = new LogModel();
            $log->user_id =  auth()->check() ? auth()->user()->id : null;
            $log->menu =  'Manajemen User';
            $log->aksi =  'Gagal Update User ' . $request->nama;
            $log->client_info =  $request->server('HTTP_USER_AGENT');
            $log->target_id =  'Gagal Update User ' . $request->nama;
            $log->ip_address =   $request->ip();
            $log->status =  "Error " . $e->getMessage();
            $log->save();

            return response()->json(['message' => 'Gagal, data User gagal disimpan', 'error' => $e->getMessage()], 422);
        }
    }
    public function destroy($id, Request $request)
    {
        $nama = '';
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemuka m mn'], 422);
        }

        $data = User::where('id', $decryptedId)->first();
        $nama = $data->name;
        if (!$data) return response()->json(['message' => 'data tidak ditemukan'], 422);

        try {
            DB::beginTransaction();

            $log = new LogModel();
            $log->user_id =  auth()->check() ? auth()->user()->id : null;
            $log->menu =  'Manajemen User';
            $log->aksi =  'Hapus User ' . $data->name;
            $log->client_info =  $request->server('HTTP_USER_AGENT');
            $log->target_id =  'Hapus User ' . $data->name;
            $log->ip_address =   $request->ip();
            $log->status =  "Berhasil Hapus User " . $data->name;
            $log->save();

            $data->delete();
            DB::commit();
            return response()->json(['message' => $nama . ' telah dihapus']);
        } catch (Exception $e) {
            DB::rollBack();
            $log = new LogModel();
            $log->user_id =  auth()->check() ? auth()->user()->id : null;
            $log->menu =  'Manajemen User';
            $log->aksi =  'Gagal Hapus User ' . $data->name;
            $log->client_info =  $request->server('HTTP_USER_AGENT');
            $log->target_id =  'Gagal Hapus User ' . $data->name;
            $log->ip_address =   $request->ip();
            $log->status =  "Error " . $e->getMessage();

            return response()->json(['message' =>  $nama . ' gagal dihapus', 'error' => $e->getMessage()], 422);
        }
    }
}
