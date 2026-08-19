<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// Redirect root to ID Studio
Route::get('/', function () {
    return redirect()->route('id-studio');
});

// ID Studio View Route
Route::get('/id-studio', function () {
    return view('id-studio');
})->name('id-studio');

// Backend Proxy Route (Bypasses Browser CORS)
Route::get('/api/students', function () {
    $apiUrl = env('STUDENT_API_URL');

    if (!$apiUrl) {
        return response()->json(['error' => 'STUDENT_API_URL missing in .env'], 500);
    }

    try {
        $response = Http::timeout(15)->get($apiUrl);
        return $response->json();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to reach Google Sheets: ' . $e->getMessage()], 500);
    }
});