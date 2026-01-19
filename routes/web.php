<?php

use App\Http\Controllers\MakeRoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappGajiController;

Route::get('/reload-captcha', [App\Http\Controllers\Auth\LoginController::class, 'reloadCaptcha']);

Route::get('/testrole', [\App\Http\Controllers\UserController::class, 'testRole'])->name('test-role');

Auth::routes([
    'register' => false,
]);

Route::get('login_siswa', [\App\Http\Controllers\Auth\LoginController::class, 'loginWithToken'])->name('login-siswa');

Route::get('/', [App\Http\Controllers\Controller::class, 'welcome']);

Route::get('/preview', function () {
    return view('preview');
});
Route::get('make-role', [MakeRoleController::class, 'makeRole']);

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');

    Route::resource('profile', \App\Http\Controllers\Admin\ProfileController::class)->names('profile');

    Route::prefix('manajemen-user')->name('manajemen-user.')->group(function () {
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\ManajemenUserController::class, 'getColumn'])->name('get-column');
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\ManajemenUserController::class, 'getData'])->name('get-data');
    });

    Route::resource('manajemen-user', \App\Http\Controllers\Admin\Utilitas\ManajemenUserController::class)->names('manajemen-user');

    Route::prefix('notifikasi-whatsapp')->name('notifikasi-whatsapp.')->group(function () {
        Route::get('get-siswa', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappController::class, 'getSiswa'])->name('get-siswa');
        Route::post('send-wa', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappController::class, 'sendWa'])->name('send-wa');
    });

    Route::resource('notifikasi-whatsapp', \App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappController::class)->names('notifikasi-whatsapp');

    Route::prefix('notifikasi-whatsapp-tagihan')->name('notifikasi-whatsapp-tagihan.')->group(function () {
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTagihanController::class, 'getData'])->name('get-data');
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTagihanController::class, 'getColumn'])->name('get-column');
        Route::get('cetak', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTagihanController::class, 'cetak'])->name('cetak');
        Route::post('send-wa', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTagihanController::class, 'sendWhatsapp'])->name('send-wa');
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTagihanController::class, 'getKelas'])->name('get-kelas');
    });
    Route::resource('notifikasi-whatsapp-tagihan', \App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTagihanController::class)->names('notifikasi-whatsapp-tagihan');

    Route::prefix('notifikasi-whatsapp-tunggakan')->name('notifikasi-whatsapp-tunggakan.')->group(function () {
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class, 'getKelas'])->name('get-kelas');
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class, 'getData'])->name('get-data');
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class, 'getColumn'])->name('get-column');
        Route::get('cetak', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class, 'cetak'])->name('cetak');
        Route::post('send-wa', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class, 'sendWhatsapp'])->name('send-wa');
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class, 'getKelas'])->name('get-kelas');
    });
    Route::resource('notifikasi-whatsapp-tunggakan', \App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTunggakanController::class)->names('notifikasi-whatsapp-tunggakan');

    Route::prefix('notifikasi-whatsapp-tanggungan')->name('notifikasi-whatsapp-tanggungan.')->group(function () {
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTanggunganController::class, 'getKelas'])->name('get-kelas');
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTanggunganController::class, 'getData'])->name('get-data');
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTanggunganController::class, 'getColumn'])->name('get-column');
        Route::post('send-wa', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTanggunganController::class, 'sendWhatsapp'])->name('send-wa');
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappTanggunganController::class, 'getKelas'])->name('get-kelas');
    });

    Route::resource('notifikasi-whatsapp-tanggungan', \App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappGajiController::class)->names('notifikasi-whatsapp-tanggungan');

    // Route::prefix('notifikasi-whatsapp-gaji')->name('notifikasi-whatsapp-gaji.')->group(function () {
    //     Route::get('gaji', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappGajiController::class, 'index'])->name('gaji.index');
    //     Route::post('gaji/upload', [\App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappGajiController::class, 'upload'])->name('gaji.upload');    
    // });
    // Route::resource('notifikasi-whatsapp-gaji', \App\Http\Controllers\Admin\Utilitas\NotifikasiWhatsappGajiController::class)->names('notifikasi-whatsapp-gaji');

    // Route::prefix('notifikasi-whatsapp-gaji')->name('notifikasi-whatsapp-gaji.')->group(function () {
    //     Route::get('/gaji', [NotifikasiWhatsappGajiController::class, 'index'])->name('index');
    //     Route::post('/gaji/upload', [NotifikasiWhatsappGajiController::class, 'upload'])->name('upload');
    // });


    Route::prefix('data-siswa')->name('data-siswa.')->group(function () {
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\DataSiswaController::class, 'getKelas'])->name('get-kelas');
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\DataSiswaController::class, 'getData'])->name('get-data');
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\DataSiswaController::class, 'getColumn'])->name('get-column');
        Route::post('send-wa', [\App\Http\Controllers\Admin\Utilitas\DataSiswaController::class, 'sendWhatsapp'])->name('send-wa');
        Route::post('get-kelas', [\App\Http\Controllers\Admin\Utilitas\DataSiswaController::class, 'getKelas'])->name('get-kelas');
    });
    Route::resource('data-siswa', \App\Http\Controllers\Admin\Utilitas\DataSiswaController::class)->names('data-siswa');

    Route::prefix('log-whatsapp')->name('log-whatsapp.')->group(function () {
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\LogWhatsappController::class, 'getData'])->name('get-data');
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\LogWhatsappController::class, 'getColumn'])->name('get-column');
    });
    Route::resource('log-whatsapp', \App\Http\Controllers\Admin\Utilitas\LogWhatsappController::class)->names('log-whatsapp');

    Route::prefix('log-aktifitas')->name('log-aktifitas.')->group(function () {
        Route::get('get-data', [\App\Http\Controllers\Admin\Utilitas\LogAktifitasController::class, 'getData'])->name('get-data');
        Route::get('get-column', [\App\Http\Controllers\Admin\Utilitas\LogAktifitasController::class, 'getColumn'])->name('get-column');
    });
    Route::resource('log-aktifitas', \App\Http\Controllers\Admin\Utilitas\LogAktifitasController::class)->names('log-aktifitas');
});

Route::get('/gaji', [NotifikasiWhatsappGajiController::class, 'index'])->name('gaji.index');
Route::post('/gaji/upload-gaji-tsanawiyah', [NotifikasiWhatsappGajiController::class, 'uploadGajiTsanawiyah'])->name('upload.gaji-tsanawiyah');
Route::post('/gaji/upload-gaji-tetap', [NotifikasiWhatsappGajiController::class, 'uploadGajiTetap'])->name('upload.gaji-tetap');

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);