<?php


use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return Redirect::route('video.videosPage');
})->middleware('auth')->name('dashboard');


Route::name('video.')->middleware('auth')->group(function () {
    Route::get('videosPage', [VideoController::class, 'videosPage'])->name('videosPage');
    Route::get('createPage', [VideoController::class, 'createPage'])->name('createPage');
    Route::get('showOne/{video}', [VideoController::class, 'showOne'])->name('showOne');
    Route::post('createOne', [VideoController::class, 'createOne'])->name('createOne');
    Route::post('like/{video}', [VideoController::class, 'like'])->name('like');
    Route::post('dislike/{video}', [VideoController::class, 'dislike'])->name('dislike');
    Route::delete('removeOne/{video}', [VideoController::class, 'removeOne'])->name('removeOne');
});



require __DIR__ . '/auth.php';
