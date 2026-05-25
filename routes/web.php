<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;


Route::get('/', [TransactionController::class, 'index']);
Route::post('/transaction', [TransactionController::class, 'store']);
Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);
// Route สำหรับเปิดหน้าฟอร์มแก้ไขข้อมูล
Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit']);

// Route สำหรับรับข้อมูลที่แก้เสร็จแล้วไปอัปเดตลง Database (ใช้ PUT)
Route::put('/transaction/{id}', [TransactionController::class, 'update']);
