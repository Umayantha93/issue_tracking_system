<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('create-category', [TrackingController::class, 'createCategory'])->name('create.category');
Route::post('create-subcategory', [TrackingController::class, 'createSubcategory'])->name('create.subcateory');

Route::post('create-issue', [TrackingController::class, 'createIssue'])->name('create.issue');
Route::post('create-comment', [TrackingController::class, 'createComment'])->name('create.comment');

Route::get('list-issues', [TrackingController::class, 'listIssues'])->name('list.issues');
Route::get('select-issue/{id}', [TrackingController::class, 'selectIssue'])->name('select.issue');

Route::delete('delete-issue/{id}', [TrackingController::class, 'deleteIssue'])->name('delete.issue');
Route::delete('delete-comment/{id}', [TrackingController::class, 'deleteComment'])->name('delete.comment');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
