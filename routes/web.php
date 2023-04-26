<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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

// Middleware('auth')-> Utente Loggato
// Middleware('verified')-> Mail Verificata
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotta per il ripristino di un Elemento
    Route::post('/projects/{project:slug}/restore', [ProjectController::class, 'restore'])->name('projects.restore')->withTrashed();

    // Genero tutte le Rotte CRUD per la Risorsa Post
    // Modifico il parametro accettato dalla rotta per non avere più l'ID di default ma lo 'slug'
    Route::resource('projects', ProjectController::class)->parameters([
        'projects' => 'project:slug'
    ])->withTrashed(['show', 'edit', 'update', 'destroy']); // Includo i "cestinati" alle rotte per poter eseguire tutte le operazioni su di essi

});

require __DIR__ . '/auth.php';
