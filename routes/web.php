<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\ImpersonateController;
use Illuminate\Http\Request;
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

Route::get('/impersonate/take/{id}/{guardName?}',[ImpersonateController::class, 'take'])->name('impersonate');
Route::get('/impersonate/leave',
[\Lab404\Impersonate\Controllers\ImpersonateController::class, 'leave'])->name('impersonate.leave');

Route::get('/docs/{file?}', [DocsController::class, 'index'])->name('docs.index');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:web', 'charter.user'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:web', 'charter.user'])->get('/id', function (Request $request) {
    dd(auth());
})->name('id');

Route::get('memberships/{membership}', function (\App\Models\Membership $membership) {
    return $membership->toJson();
});
