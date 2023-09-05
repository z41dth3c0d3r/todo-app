<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [TodoController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix("todo")->group(function () {
    Route::get("/create", function () {
        return view("todo.create");
    })->name("todo.index");
    Route::post("/create", [TodoController::class, 'store'])->name("todo.create");
    Route::post("/complete", [TodoController::class, 'completeTodo'])->name("todo.complete");
    Route::delete("/", [TodoController::class, 'deleteTodo'])->name("todo.destroy");
    Route::get("/{id}/edit", [TodoController::class, 'edit'])->name('todo.edit');
    Route::put("/update", [TodoController::class, 'update'])->name('todo.update');
});

require __DIR__ . '/auth.php';
