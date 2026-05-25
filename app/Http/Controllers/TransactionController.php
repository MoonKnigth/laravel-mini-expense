<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('category')->latest()->get();

        // เพิ่มบรรทัดนี้: ดึงหมวดหมู่ทั้งหมดมาด้วย
        $categories = Category::all();

        // โยนทั้ง 2 ตัวแปรไปที่หน้า blade
        return view('index', compact('transactions', 'categories'));
    }
    public function store(Request $request)
    {
        // 1. รับค่าจากฟอร์ม และบันทึกลง Database
        Transaction::create($request->all());

        // 2. บันทึกเสร็จ ให้เด้งกลับมาหน้าเดิม
        return redirect()->back();
    }
    public function destroy($id)
    {
        // 1. สั่งลบข้อมูลที่มี id ตรงกับที่ส่งมา
        Transaction::destroy($id);

        // 2. ลบเสร็จให้เด้งกลับมาหน้าเดิม
        return redirect()->back();
    }

    // ดึงข้อมูลเก่ามาโชว์ในหน้าฟอร์ม
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id); // ดึงข้อมูลรายการนั้นมา
        $categories = Category::all(); // ดึงหมวดหมู่มาทำ Dropdown

        return view('edit', compact('transaction', 'categories'));
    }

    // รับข้อมูลจากฟอร์มมาเซฟทับของเดิม
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all()); // เซฟทับข้อมูลใหม่

        return redirect('/'); // กลับไปหน้าแรก
    }
}
