<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/login', function () {
    return view('auth.admin.masuk');
})->name('admin.login');

Route::get('/login/kurir', function () {
    return view('auth.kurir.masuk');
})->name('kurir.login');

Route::get('/login/user', function () {
    return view('auth.user.masuk');
})->name('user.login');

Route::get('/register/user', function () {
    return view('auth.user.daftar');
})->name('user.register');

Route::get('/dashboard/kurir', function () {
    return view('kurir.dashboard');
})->name('dashboard.kurir');

Route::get('/admin/kelola_kurir', function () {
    return view('admin.kelola_kurir');
})->name('admin.kurir');

Route::get('/admin/tambah_kurir', function () {
    return view('admin.tambah_kurir');
})->name('admin.tambah_kurir');

Route::post('/admin/tambah_kurir', function () {
    dd(request()->all());
})->name('admin.tambah_kurir.submit');

Route::get('/admin/edit_kurir', function () {
    return view('admin.edit_kurir');
})->name('admin.edit_kurir');

Route::post('/admin/edit_kurir', function () {
    dd(request()->all());
})->name('admin.edit_kurir.submit');

Route::get('/admin/status_pengiriman', function () {
    return view('admin.status_pengiriman');
})->name('admin.status_pengiriman');

Route::get('/admin/kelola_pengiriman', function () {
    return view('admin.kelola_pengiriman');
})->name('admin.kelola_pengiriman');

Route::get('/admin/history_pengiriman', function () {
    return view('admin.history_pengiriman');
})->name('admin.history_pengiriman');

    Route::get('/admin/dashboard_admin', function () {
        return view('admin.dashboard_admin');
    })->name('admin.dashboard_admin');

    Route::get('/kurir/daftar_pengiriman', function () {
        return view('kurir.daftar_pengiriman');
    })->name('kurir.daftar_pengiriman');
    
    Route::get('/kurir/kelola_profile_kurir', function () {
        return view('kurir.kelola_profile_kurir');
    })->name('kurir.kelola_profile_kurir');
    
    Route::get('/kurir/live_tracking', function () {
        return view('kurir.live_tracking');
    })->name('kurir.live_tracking');
    
    Route::get('/kurir/kelola_status', function () {
        return view('kurir.kelola_status');
    })->name('kurir.kelola_status');
    
    Route::get('/kurir/history_pengiriman_kurir', function () {
        return view('kurir.history_pengiriman_kurir');
    })->name('kurir.history_pengiriman_kurir');

    Route::get('/admin/live_tracking_admin', function () {
        return view('/admin/live_tracking_admin');
    })->name('/admin/live_tracking_admin');

    Route::get('/admin/kelola_profile_admin', function () {
        return view('admin.kelola_profile_admin');
    })->name('admin.kelola_profile_admin');

