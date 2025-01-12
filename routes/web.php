<?php

use App\Models\Tasks;
use App\Livewire\Task;
use App\Livewire\Client;
use App\Livewire\Leader;
use App\Livewire\Project;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/projects', Project::class)->name('projects.index');
Route::get('/clients', Client::class)->name('clients.index');
Route::get('/leader', Leader::class)->name('leader.index');
Route::get('/tasks', Task::class)->name('tasks.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
