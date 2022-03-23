<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\ImpersonateController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

Route::get('/docs/{file?}', [DocsController::class, 'index'])->name('docs.index');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/billing',function(){
    $value = config('billing');
    $dt = Carbon::create($value['snw_year'], $value['snw_month'], $value['snw_day'], $value['snw_hours'] , $value['snw_minutes'],$value['snw_seconds']);
    return view('comingsoon::comingsoon',compact('value','dt'));
})->name('billing');

Route::get('/guest-iframe/billing',function(){

    return view('iframes::jetstream.guest-iframe',['iframeSource' => '/billing']);
})->name('guest-iframe.billing');

$authMiddleware = config('jetstream.guard')
? 'auth:'.config('jetstream.guard')
: 'auth';

Route::group(['middleware' => [$authMiddleware, 'has_team', 'verified']], function () {
    Route::get('/impersonate/take/{id}/{guardName?}', [ImpersonateController::class, 'take'])->name('impersonate');
    Route::get(
        '/impersonate/leave',
        [\Lab404\Impersonate\Controllers\ImpersonateController::class, 'leave']
    )->name('impersonate.leave');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});





Route::middleware(['auth:web', 'charter.user'])->get('/id', function (Request $request) {
    dd(auth());
})->name('id');

Route::get('memberships/{membership}', function (\App\Models\Membership $membership) {
    return $membership->toJson();
});

Route::get('/contact', function () {
    abort(404);
});
