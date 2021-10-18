<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [PostController::class, 'index'])->name('dashboard');

Route::get('home/{post}', [HomeController::class, 'show'])->name('home.show');

Route::middleware('auth')->group(function()
{
    Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::get('admin/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::get('admin', [AdminsController::class, 'index'])->name('admin.index');
    Route::get('admin/posts/create',[PostController::class, 'create'])->name('post.create');
    Route::get('admin/posts', [PostController::class, 'index'])->name('post.index');
    Route::delete('admin/posts/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('admin/posts/store',[PostController::class, 'store'])->name('post.store');
    Route::patch('admin/posts/{post}/update', [PostController::class, 'update'])->name('post.update');
});