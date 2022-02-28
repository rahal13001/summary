<?php

use App\Http\Controllers\Account\PasswordController;
use App\Http\Controllers\Admin\IndicatorsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\MyreportsController;
use App\Http\Controllers\Permissions\AssignController;
use App\Http\Controllers\Permissions\PermissionsController;
use App\Http\Controllers\Permissions\RolesController;
use App\Http\Controllers\Permissions\UsersController;
use App\Http\Controllers\ProfilesController;
use App\Models\Indicator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/profile', [ProfilesController::class, 'profile']);


// Route::get('/pdftes', function () {
//     // $role = Role::find(3);
//     // $role->givePermissionTo('create post');
//     // dd($role);

//     return view('pdf.pdftes');

// });

//apapun rolenya bisa masuk
Route::middleware('has.role')->group(function(){
    Route::view('dashboard', 'dashboard');
});

Auth::routes();

//untuk 5w1h-semua
Route::prefix('5w1h-semua')->middleware('has.role')->group(function(){
    Route::get('', [ReportsController::class, 'index'])->name('report_index');
    Route::get('/humas', [ReportsController::class, 'humas'])->name('report_humas');
    Route::get('/tambah', [ReportsController::class, 'create'])->name('report_create');
    Route::post('', [ReportsController::class, 'store'])->name('report_post');
    Route::get('{report}/show', [ReportsController::class, 'show'])->name('report_show');

    Route::group(['middleware' => ['permission:show user']], function () {
        Route::get('{report}/edit', [ReportsController::class, 'edit'])->name('report_edit');
        Route::put('{report}', [ReportsController::class, 'update'])->name('report_update');
        Route::delete('{report}', [ReportsController::class, 'delete'])->name('report_delete');
    });
});

//5w1h-ku
Route::get('/', [MyreportsController::class, 'myreport'])->name('myreport')->middleware('auth', 'verified');
Route::prefix('5w1h')->middleware('has.role')->group(function(){
    Route::get('/pengikut', [MyreportsController::class, 'pengikut'])->name('pengikut');
    Route::get('/tambah', [MyreportsController::class, 'create'])->name('myreport_create');
    Route::post('', [MyreportsController::class, 'store'])->name('myreport_post');
    Route::get('{report}/edit', [MyreportsController::class, 'edit'])->name('myreport_edit');
    Route::put('{report}', [MyreportsController::class, 'update'])->name('myreport_update');
    Route::get('{report}/show', [MyreportsController::class, 'show'])->name('myreport_show');
    Route::delete('{report}', [MyreportsController::class, 'delete'])->name('myreport_delete');
});

//membuat slug
Route::get('/5w1h/posts/checkSlug', [ReportsController::class, 'checkSlug']);
Route::get('/5w1h/post/checkSlug', [IndicatorsController::class, 'checkSlug']);


//untuk iku
Route::prefix('IKU')->middleware('permission:create indicator')->group(function(){
    Route::get('', [IndicatorsController::class, 'create'])->name('indicator_create');
    Route::post('', [IndicatorsController::class, 'store'])->name('indicator_post');
    Route::get('{indicator}/edit', [IndicatorsController::class, 'edit'])->name('indicator_edit');
    Route::put('{indicator}', [IndicatorsController::class, 'update'])->name('indicator_update');
    Route::delete('{indicator}', [IndicatorsController::class, 'destroy'])->name('indicator_delete');
    Route::get('{indicator}/report', [IndicatorsController::class, 'iku'])->name('iku');
});


//membuat role and permission
Route::prefix('role-and-permissions')->middleware('permission:assign role')->group(function(){

    //untuk membuat user
    Route::prefix('user')->group(function(){
        Route::get('', [UsersController::class, 'create'])->name('user_create');
        Route::post('', [UsersController::class, 'store'])->name('user_post');
        Route::get('{user}/edit', [UsersController::class, 'edit'])->name('user_edit');
        Route::put('{user}', [UsersController::class, 'update'])->name('user_update');
        Route::delete('{user}', [UsersController::class, 'destroy'])->name('user_delete');
    });

    //untuk memberikan hak akses kepada role
    Route::prefix('assign')->group(function(){
        Route::get('', [AssignController::class, 'create'])->name('assign_create');
        Route::post('', [AssignController::class, 'store'])->name('assign_post');
        Route::get('{role}/edit', [AssignController::class, 'edit'])->name('assign_edit');
        Route::put('{role}', [AssignController::class, 'update'])->name('assign_update');
        Route::delete('{role}', [RolesController::class, 'destroy'])->name('assign_delete');
    });

    //untuk membuat role (peran)
    Route::prefix('role')->group(function(){
        Route::get('', [RolesController::class, 'index'])->name('role_index');
        Route::get('/tambah-role', [RolesController::class, 'create'])->name('role_tambah');
        Route::post('', [RolesController::class, 'store'])->name('role_simpan');
        Route::get('{role}/edit', [RolesController::class, 'edit'])->name('role_edit');
        Route::put('{role}', [RolesController::class, 'update'])->name('role_update');
        Route::delete('{role}', [RolesController::class, 'destroy'])->name('role_delete');
    });

    //untuk membuat hak akses
       Route::prefix('permission')->group(function(){
        Route::get('', [PermissionsController::class, 'index'])->name('permission_index');
        Route::get('/tambah-permission', [PermissionsController::class, 'create'])->name('permission_tambah');
        Route::post('', [PermissionsController::class, 'store'])->name('permission_simpan');
        Route::get('{permission}/edit', [PermissionsController::class, 'edit'])->name('permission_edit');
        Route::put('{permission}', [PermissionsController::class, 'update'])->name('permission_update');
        Route::delete('{permission}', [PermissionsController::class, 'destroy'])->name('permission_delete');
    });
});

//Fitur Ekspor
//ekspor excel 5w1hku
Route::get('/user_excel', [MyreportsController::class, 'exportexcel'])->name('user_excel');
//ekspor excel seluruh data untuk admin
Route::get('/admin_excel', [ReportsController::class, 'exportexcel'])->name('admin_excel');
//eksporexcel IKU
Route::get('/iku_excel/{indicator}', [IndicatorsController::class, 'exportexcel'])->name('iku_excel');
//Ekspor PDF 5W1H
Route::get('pdf/{report}', [ReportsController::class, 'export_pdf'])->name('pdf');

//Lihat dokumentasi lainnya
Route::get('lihat_lainnya/{report}',[ReportsController::class, 'viewpdf'])->name('view_pdf');
//Lihat dokumentasi st
Route::get('lihat_st/{report}',[ReportsController::class, 'viewst'])->name('view_st');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

//Ubah Password
Route::middleware('auth')->group( function() {
    Route::get('ubahpassword', [PasswordController::class, 'edit'])->name('password_edit');
    Route::patch('ubahpassword/{password}', [PasswordController::class, 'update'])->name('password_update');
});

Auth::routes(['verify' => true]);