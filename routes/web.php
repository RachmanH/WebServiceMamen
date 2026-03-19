<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\GroqChat;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard bawaan
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ✅ TAMBAHAN: GROQ CHAT
    Route::get('/chat-groq', function () {
        return view('chat-groq');
    })->name('chat.groq');
});
