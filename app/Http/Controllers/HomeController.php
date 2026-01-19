<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        if (auth()->user()) {
            if (auth()->user()->hasRole('siswa')) {
                return redirect()->route('siswa.index');
            } else if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.index');
            }
        }
        return redirect()->route('login');
    }
}
