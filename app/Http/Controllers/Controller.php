<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function welcome()
    {
        if (auth()->user()) {
            if (auth()->user()->hasRole('siswa')) {
                return redirect()->route('siswa.index');
            } else if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.notifikasi-whatsapp-tagihan.index');
            }
        }
        return redirect()->route('login');
    }
}
