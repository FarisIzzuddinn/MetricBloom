<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TerasController;
use App\Http\Controllers\AddKpiController;
use App\Http\Controllers\UserKpiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\Auth\ForgotPassController;
use App\Http\Controllers\institutionAdminController;
use App\Http\Controllers\StateAdminController;

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

Route::get('forget-password', [ForgotPassController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPassController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPassController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPassController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::resource('profileEdit', AuthController::class);

// ===================== SUPER ADMIN ======================
Route::group(['middleware' => ['role:super admin|admin']], function () {
    // Super Admin Dashboard 
    Route::get('/Dashboard/SuperAdmin', [SuperAdminController::class, 'index'])->name('superAdminDashboard');
    
    // Manage State and Institution
    Route::resource('states', StateController::class);
    Route::resource('institutions', InstitutionController::class);
    
    

    // Super admin permission 
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);
    

    // Super admin set roles 
    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy'])->middleware('permission:delete role');
    Route::get('roles/{roleId}/give-permission', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permission', [RoleController::class, 'updatePermissionToRole']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Super admin users
    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
    Route::get('/get-institutions/{stateId}', [UserController::class, 'getInstitutions']);

    Route::group(['middleware' => ['permission:view dashboard']], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });
    

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
  
    Route::post('/chartTitle', [ChartController::class, 'updateChartTitle'])->name('updateChartTitle');
    Route::post('/chartTitle/rename', [ChartController::class, 'create'])->name('chartRename');
    Route::get('/charts', [ChartController::class, 'showCharts'])->name('charts.show');

    Route::get('/kpi-data/{state}', [AdminController::class, 'getKpiDataByState']);
});

// Admin State
Route::middleware(['auth', 'role:Admin State'])->group(function () {
    Route::resource('admin-state-kpis', StateAdminController::class);
    Route::get('/state-admin/dashboard', [StateAdminController::class, 'index'])->name('stateAdmin.dashboard');
    Route::get('/state-admin/kpi-management', [StateAdminController::class, 'manageKPI'])->name('stateAdmin.kpi');
    Route::post('/admin-state-kpis', [StateAdminController::class, 'store'])->name('stateAdmin.store');
});

// Admin Institution
Route::middleware(['auth', 'role:Institution Admin'])->group(function () {
    Route::resource('admin-institution-kpis', institutionAdminController::class);
    Route::get('/institution-admin/dashboard', [institutionAdminController::class, 'index'])->name('institutionAdmin.dashboard');
    Route::get('/institution-admin/kpi-management', [institutionAdminController::class, 'manageKPI'])->name('institutionAdmin.kpi');
    Route::post('/institution-admin/kpi/assign', [institutionAdminController::class, 'assignKpi'])->name('institutionAdmin.kpi.assign');
});


// ===================== USER ======================
// Route::middleware(['role:user'])->group(function () {
    Route::put('/user/addKpi/update/{id}', [UserKpiController::class, 'update'])->name('user.update');
    Route::get('/user/{AddKPI}/edit', [UserKpiController::class, 'edit'])->name('user.edit');
    Route::post('/user/KPI/IndexKPI', [UserKpiController::class, 'storeInput'])->name('user.kpi.storeInput');
    Route::get('/user/KPI/IndexKPI', [UserKpiController::class, 'index'])->name('user.kpi.input'); 
// });

// ===================== LOGOUT ======================
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

