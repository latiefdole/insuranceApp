<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosCIUController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Exports\PosResponseCIUExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserSapa;
// Route::get('/', function () {
//     return view('welcome');
// });

// // Routes for login and logout


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
 
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('auth');


    Route::get('/search-users', function (Request $request) {
        $search = $request->get('term', '');
    
        $users = UserSapa::where('DisplayName', 'like', '%' . $search . '%')
            ->take(10)
            ->get();
            // dd($users);  // This will dump the results and stop the execution

        return response()->json($users);
    });
    
//
//groupuser
Route::resource('master/users', UserController::class);
// Grouping PosCIU routes
Route::prefix('master/posciu')->group(function () {
    Route::get('/account', [PosCIUController::class, 'indexciu'])->name('posciu.indexciu.data');
    Route::get('/data', [PosCIUController::class, 'indexciu'])->name('posciu.indexciu.data');
    Route::get('/getdata', [PosCIUController::class, 'getdata']);
    Route::get('/response', [PosCIUController::class, 'indexresponse'])->name('posciu.indexresponse.data');
    Route::get('/export-response', [PosCIUController::class, 'exportResponse'])->name('export.response');
});

// Grouping Insurance Order routes
Route::prefix('orders')->group(function () {
    Route::get('/get-order', [OrderController::class, 'showForm'])->name('get.order.form');
    Route::post('/get-order/result', [OrderController::class, 'getOrderInsuranceCIU'])->name('get.order.data');
    Route::post('/post-data', [PostingController::class, 'postData'])->name('post.data');
    Route::get('/post-data/results', [PostingController::class, 'resultsView'])->name('results.view');

    Route::get('/get-void', [PostingController::class, 'showForm'])->name('void.order.form');
    Route::get('/post-void', [PostingController::class, 'postVoid'])->name('post.void.data');
    // Route::post('/post-data', [PostingController::class, 'getData'])->name('post.data.getdata');
    // Route::post('/post-data/posting', [PostingController::class, 'postingCIU'])->name('post.data.posting');
});

