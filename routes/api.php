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

Route::post('create-category', [TrackingController::class, 'createCategory']);
Route::post('create-subcategory', [TrackingController::class, 'createSubcategory']);

Route::post('create-issue', [TrackingController::class, 'createIssue']);
Route::post('create-comment', [TrackingController::class, 'createComment']);

Route::get('list-issues', [TrackingController::class, 'listIssues']);
Route::get('select-issue/{id}', [TrackingController::class, 'selectIssue']);

Route::delete('delete-issue/{id}', [TrackingController::class, 'deleteIssue']);
Route::delete('delete-comment/{id}', [TrackingController::class, 'deleteComment']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
