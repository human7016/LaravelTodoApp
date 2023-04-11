<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoldersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TasksController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// トップページ
Route::get('/', [HomeController::class,'index'])->name('home')->middleware('auth');
// Route::group(['middleware' => 'can:view,folder'], function() {
//     Route::get('/folders/{folder}/tasks', [TasksController::class, 'index'])->name('tasks.index')->middleware('auth');
// });
Route::get('/folders/{folder}/tasks', [TasksController::class, 'index'])->name('tasks.index')->middleware('auth','can:view,folder');
// フォルダ作成
Route::get('/folders/create', [FoldersController::class,'showCreateForm'])->name('folders.create')->middleware('auth');
Route::post('/folders/create', [FoldersController::class,'create'])->middleware('auth');
// タスク作成
Route::get('/folders/{folder}/tasks/create', [TasksController::class,'showCreateForm'])->name('tasks.create')->middleware('auth','can:view,folder');
Route::post('/folders/{folder}/tasks/create', [TasksController::class,'create'])->middleware('auth','can:view,folder');
// タスク編集
Route::get('/folders/{folder}/tasks/{task}/edit', [TasksController::class,'showEditForm'])->name('tasks.edit')->middleware('auth','can:view,folder');
Route::post('/folders/{folder}/tasks/{task}/edit', [TasksController::class, 'edit'])->middleware('auth','can:view,folder');
// ポリシー

require __DIR__.'/auth.php';