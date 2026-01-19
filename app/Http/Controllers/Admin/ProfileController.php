<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function index()
    {
        $id = Auth::id();

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
            return view('admin.profile.index', $data);
        } else {
            return redirect()->route('admin.users.index');
        }
    }
}
