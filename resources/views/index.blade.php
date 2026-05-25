<!DOCTYPE html>
<html>

<head>
    <title>Mini Expense</title>
</head>

<body>
    <h1>ระบบบันทึกรายรับรายจ่าย (Laravel Blade)</h1>

    <table border="1">
        <thead>
            <tr>
                <th>วันที่</th>
                <th>รายการ</th>
                <th>หมวดหมู่</th>
                <th>ประเภท</th>
                <th>จำนวนเงิน</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <form action="/transaction" method="POST" style="margin-bottom: 20px;">
                @csrf <input type="date" name="date" required>

                <input type="text" name="title" placeholder="ชื่อรายการ" required>

                <select name="category_id" required>
                    <option value="">-- เลือกหมวดหมู่ --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <select name="type" required>
                    <option value="EXPENSE">รายจ่าย</option>
                    <option value="INCOME">รายรับ</option>
                </select>

                <input type="number" name="amount" placeholder="จำนวนเงิน" step="0.01" required>

                <button type="submit">บันทึก</button>
            </form>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->title }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td>{{ $transaction->type }}</td>
                    <td>{{ number_format($transaction->amount, 2) }} ฿</td>
                    <td>
                        <button> <a href="/transaction/{{ $transaction->id }}/edit"
                                style="margin-right: 10px;">แก้ไข</a>
                        </button>

                        <form action="/transaction/{{ $transaction->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('ยืนยันการลบรายการนี้?')">ลบทิ้ง</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
