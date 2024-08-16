<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddKpiController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\UserKpiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SoController;
use App\Http\Controllers\TerasController;
use App\Models\AddKpi;

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
    return view('/auth/login');
});

// ===================== REGISTER & LOGIN ======================
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');

// ===================== SUPER ADMIN ======================
Route::group(['middleware' => ['role:super admin']], function () {
    // Super admin permission 
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    // Super admin set roles 
    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permission', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permission', [RoleController::class, 'updatePermissionToRole']);

    // Super admin users
    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
});

// ===================== ADMIN ======================
Route::group(['middleware' => ['role:admin']], function () {
    // dashboard 
    Route::get('/admin/dashboard/index', [AdminController::class, 'index'])->name('admin.index');
    // crud Kpi
    Route::get('/admin/kpi', [AddKpiController::class, 'index'])->name('admin.kpi');  
    Route::get('/kpi/add', [AddKpiController::class, 'create'])-> name('kpi.add');
    Route::post('/admin/kpi', [AddKpiController::class, 'store'])->name('kpi.store');
    Route::get('AddKPI/{AddKPI}/edit', [AddKpiController::class, 'edit'])->name('kpi.edit');
    Route::delete('/admin/Kpi/IndexKPI/{addKpi}', [AddKpiController::class, 'destroy'])->name('kpi.destroy');
    Route::put('/admin/addKpi/update/{id}', [AddKpiController::class, 'update'])->name('kpi.update');

    //crud teras 
    Route::resource('teras', TerasController::class);
    Route::get('teras/{terasID}/delete', [TerasController::class, 'destroy']);

    //crud so 
    Route::resource('so', SoController::class);
    Route::get('so/{soID}/delete', [SoController::class, 'destroy']);
});

// ===================== USER ======================
Route::middleware(['role:user'])->group(function () {
    Route::put('/user/addKpi/update/{id}', [UserKpiController::class, 'update'])->name('user.update');
    Route::get('/user/{AddKPI}/edit', [UserKpiController::class, 'edit'])->name('user.edit');
    Route::post('/user/KPI/IndexKPI', [UserKpiController::class, 'storeInput'])->name('user.kpi.storeInput');
    Route::get('/user/KPI/IndexKPI', [UserKpiController::class, 'index'])->name('user.kpi.input');

    // Route::get('/user/KPI/IndexKPI', [UserKpiController::class, 'charts'])->name('user.kpi.charts');
});

// ===================== LOGOUT ======================
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

