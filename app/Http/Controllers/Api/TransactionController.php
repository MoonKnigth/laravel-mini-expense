<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // ดึงข้อมูลทั้งหมด (Read)
    public function index()
    {
        $transactions = Transaction::with('category')->latest()->get();

        // พ่นออกมาเป็น JSON พร้อม HTTP Status 200 (OK)
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    // เพิ่มข้อมูลใหม่ (Create)
    public function store(Request $request)
    {
        // แนะนำให้ใส่ Validate กันข้อมูลขยะก่อน
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id'
        ]);

        $transaction = Transaction::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'เพิ่มรายการสำเร็จ!',
            'data' => $transaction
        ], 201); // 201 คือรหัสบอกว่า Created (สร้างข้อมูลสำเร็จ)
    }

    // อัปเดตข้อมูล (Update)
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
        }

        $transaction->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'อัปเดตข้อมูลสำเร็จ!',
            'data' => $transaction
        ], 200);
    }

    // ลบข้อมูล (Delete)
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'ลบข้อมูลสำเร็จ!'
        ], 200);
    }
}
