<?php

use App\Http\Middleware\RedirectIfAuthenticated;
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

Route::get('/qr_scan',  [App\Http\Controllers\QRController::class, 'index']);
Route::post('/qr_scan',  [App\Http\Controllers\QRController::class, 'input']);
Route::get('/error',  [App\Http\Controllers\QRController::class, 'error']);

Route::middleware(RedirectIfAuthenticated::class)->get('/admin/login',  [App\Http\Controllers\Admin\LoginController::class, 'index'])->name('login');
Route::post('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('login');
Route::get('/admin/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');

Route::get('/qr-code', function (\Illuminate\Http\Request $request) {
    if (!$request->get('code', '')) return null;
    echo \QrCode::size(500)->generate($request->get('code', ''));
});

Route::redirect('/' , '/admin');
Route::redirect('/home' , '/admin');
Route::redirect('' , '/admin');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\Admin\IndexController::class, 'index']);

    // Trash Operations
    Route::get('/admin/trash/create_qr',    [App\Http\Controllers\Admin\TrashController::class, 'createQR']);
    Route::post('/admin/trash/create_qr',   [App\Http\Controllers\Admin\TrashController::class, 'createQRSubmit']);

    Route::get('/admin/trash/list',         [App\Http\Controllers\Admin\TrashController::class, 'list']);
    Route::get('/admin/trash/detail',       [App\Http\Controllers\Admin\TrashController::class, 'detail']);
    Route::get('/admin/trash/edit',         [App\Http\Controllers\Admin\TrashController::class, 'edit']);

    // Statistics
    Route::get('/admin/stats/trash_group',      [App\Http\Controllers\Admin\StatisticsController::class, 'trashGroup']);
    Route::get('/admin/stats/trash_group_type', [App\Http\Controllers\Admin\StatisticsController::class, 'trashGroupType']);
    Route::get('/admin/stats/line_week',        [App\Http\Controllers\Admin\StatisticsController::class, 'trashLineWeek']);
    Route::get('/admin/stats/dashboard',        [App\Http\Controllers\Admin\StatisticsController::class, 'dashboard']);
    Route::get('/admin/stats/export',           [App\Http\Controllers\Admin\StatisticsController::class, 'export']);

    // Data
    Route::get('/admin/data/list',    [App\Http\Controllers\Admin\DataController::class, 'list']);
    Route::get('/admin/data/export',    [App\Http\Controllers\Admin\DataController::class, 'export']);
});

//tech/re8r8U2hrTPcgKdU
    //admin/RPh5jEL4uWU2n7r6
