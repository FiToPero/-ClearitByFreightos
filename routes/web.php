<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MessageController;



Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/Ticket-User', [TicketController::class, 'create'])->name('ticket.create');
    Route::get('/Ticket-Agent', [TicketController::class, 'edit'])->name('ticket.agent');
    Route::get('/Ticket-User/ticket', [TicketController::class, 'show'])->name('ticket.user');
    Route::post('/Ticket-User/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::post('/Ticket-Agent/update/{id}/{status}', [TicketController::class, 'updateAgent'])->name('ticket.update.agent');
    Route::post('/Ticket-User/update/{id}/{status}', [TicketController::class, 'updateUser'])->name('ticket.update.user');
    Route::get('/Message-User/{ticketId}', [MessageController::class, 'createUser'])->name('message.user');
    Route::get('/Message-Agent/{ticketId}', [MessageController::class, 'createAgent'])->name('message.agent');
    Route::post('/Message-Agent/update/{id}', [MessageController::class, 'updateAgent'])->name('message.update.agent');
    Route::post('/Message-User/update/{id}', [MessageController::class, 'updateUser'])->name('message.update.user');
    Route::post('/Message-Form/store', [MessageController::class, 'store'])->name('message.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
