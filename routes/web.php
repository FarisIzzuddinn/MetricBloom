<?php

use App\Http\Controllers\Auth\loginController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TerasController;
use App\Http\Controllers\accessController;
use App\Http\Controllers\AddKpiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ViewerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserKpiController;
use App\Http\Controllers\BahagianController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StateAdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminSectorController;
use App\Http\Controllers\all\infografikController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\pelaporanKpiController;
use App\Http\Controllers\Auth\ForgotPassController;
use App\Http\Controllers\Auth\logoutController;
use App\Http\Controllers\institutionAdminController;
use Illuminate\Auth\Events\Logout;

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

// ===================== REGISTER & LOGIN ======================
// Route::get('register', [AuthController::class, 'register'])->name('register');
// Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/', [loginController::class, 'login'])->name('login');
Route::post('/', [loginController::class, 'loginPost'])->name('login.post');

Route::get('forget-password', [ForgotPassController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPassController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPassController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPassController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Route::resource('profileEdit', AuthController::class);
//profile route
Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
Route::post('/profile', [ProfileController::class, 'store'])->name('user.profile.store');

Route::middleware(['auth'])->group(function () {

    // all roles can access this page when success auhentication 
    Route::get('/all/infografik', [infografikController::class, 'index'])->name('infografik.index');
    Route::get('/all/get-infografik', [infografikController::class, 'infografik'])->name('get-infografik');

    Route::middleware(['role:super admin'])->group(function () {

        // PENGURUSAN INSTITUSI
        Route::resource('institutions', InstitutionController::class);

        // PENGURUSAN PENGGUNA SISTEM
        Route::resource('users', UserController::class);



        Route::get('/Dashboard', [SuperAdminController::class, 'index'])->name('superAdminDashboard');

        Route::get('/pelaporan-kpi', [pelaporanKpiController::class, 'index'])->name('laporanKpi');

        Route::get('/kpis/all', [SuperAdminController::class, 'getAllKPIs'])->name('allKPIs'); 
        Route::get('/achieved-kpis', [SuperAdminController::class, 'getAchievedKpis'])->name('achieved.kpis');
    
        Route::get('access-kpi', [accessController::class, 'index'])->name('accessKpi');
        Route::get('/access-kpi/filter', [accessController::class, 'filterAccess'])->name('accessKpi.filter');
        Route::post('access-kpi-store', [accessController::class, 'store'])->name('accessKpi.store');
        Route::delete('kpi-access/{id}', [accessController::class, 'destroy'])->name('accessKpi.destroy');
    
        Route::resource('states', StateController::class);
    
        Route::resource('permissions', PermissionController::class);
        Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);
    
        Route::resource('roles', RoleController::class);
        Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy'])->middleware('permission:delete role');
        Route::get('roles/{roleId}/give-permission', [RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permission', [RoleController::class, 'updatePermissionToRole']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
        // Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
        // Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        // Route::get('/get-institutions/{stateId}', [UserController::class, 'getInstitutions']);
    
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'exportPDF'])->name('reports.pdf');
        Route::get('/reports/csv', [ReportController::class, 'exportCSV'])->name('reports.csv');
        Route::get('/reports/visual', [ReportController::class, 'visualReport'])->name('reports.visual');
    
    });

        
       

});


Route::middleware(['role:Admin State'])->group(function () {
    Route::resource('admin-state-kpis', StateAdminController::class);
    Route::get('/state-admin/dashboard', [StateAdminController::class, 'index'])->name('stateAdmin.dashboard');
    Route::get('/state-admin/kpi-management', [StateAdminController::class, 'manageKPI'])->name('stateAdmin.kpi');
    Route::put('/admin-state-kpis', [StateAdminController::class, 'updateKPI'])->name('stateAdmin.kpi.update'); 
    Route::get('/reports/state/{state}', [StateAdminController::class, 'generateReportInstitutions'])->name('reports.state');
    Route::get('reports/export/{state}', [StateAdminController::class, 'exportStateReportToPdf'])->name('reports.export.state');
});

Route::middleware(['role:Institution Admin'])->group(function () {
    Route::resource('admin-institution-kpis', institutionAdminController::class);
    Route::get('/institution-admin/dashboard', [institutionAdminController::class, 'index'])->name('institutionAdmin.dashboard');
    Route::get('/institution-admin/kpi-management', [institutionAdminController::class, 'kpiIndex'])->name('institutionAdmin.kpi');
    Route::put('/institution-admin/kpi/assign', [institutionAdminController::class, 'update'])->name('institutionAdmin.kpi.assign');
    Route::get('/kpi-details/{status}', [institutionAdminController::class, 'getKpiDetails']);
});
Route::middleware(['role:Admin Bahagian'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/adminBahagian/kpi', [UserKpiController::class, 'index'])->name('user.kpi.index');
    Route::put('/kpi/update', [UserKpiController::class, 'update'])->name('user.kpi.update');
});

Route::middleware(['role:Viewer'])->group(function () {
    Route::get('/dashboard', [ViewerController::class, 'index'])->name('viewerDashboard');
    Route::get('/reports/viewer', [ViewerController::class, 'generateViewerReport'])->name('viewerReport');
});

Route::middleware(['role:Admin Sector|super admin'])->group(function () {
    Route::get('/admin/kpi', [AddKpiController::class, 'index'])->name('admin.kpi');  
    Route::get('/kpi/add', [AddKpiController::class, 'create'])-> name('kpi.add');
    Route::post('/admin/kpi', [AddKpiController::class, 'store'])->name('kpi.store');
    Route::get('AddKPI/{AddKPI}/edit', [AddKpiController::class, 'edit'])->name('kpi.edit');
    Route::delete('/admin/Kpi/IndexKPI/{addKpi}', [AddKpiController::class, 'destroy'])->name('kpi.destroy');
    Route::put('/admin/addKpi/update/{id}', [AddKpiController::class, 'update'])->name('kpi.update');

    // testing 
    Route::get('/kpi/create', [AddKpiController::class, 'create'])-> name('kpi.create');

    //crud teras 
    Route::resource('teras', TerasController::class);
    Route::put('/teras/{teras}', [TerasController::class, 'update'])->name('teras.update');
    Route::get('teras/{terasID}/delete', [TerasController::class, 'destroy']);

    //crud so 
    Route::resource('sector', SoController::class);
    Route::get('sector/{sectorID}/delete', [SoController::class, 'destroy']);

    Route::get('bahagian', [BahagianController::class, 'index'])->name('bahagian.index');
    Route::post('bahagian', [BahagianController::class, 'store'])->name('bahagian.store');
    Route::put('bahagian/{id}', [BahagianController::class, 'update'])->name('bahagian.update');
    Route::delete('bahagian/{id}', [BahagianController::class, 'destroy'])->name('bahagian.destroy');
});

Route::middleware(['role:Admin Sector'])->group(function () {
    Route::get('/sectoradmin/dashboard', [AdminSectorController::class, 'index'])->name('adminSector.index');
});

Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);

    if (!file_exists($file)) {
        abort(404);
    }

    return response()->file($file);
})->where('path', '.*');

// ===================== LOGOUT ======================
Route::post('/logout', [logoutController::class, 'logout'])->name('logout');


