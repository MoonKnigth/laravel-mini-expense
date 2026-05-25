<!DOCTYPE html>
<html>

<head>
    <title>แก้ไขรายการ</title>
</head>

<body>
    <h1>แก้ไขรายการ</h1>

    <form action="/transaction/{{ $transaction->id }}" method="POST">
        @csrf
        @method('PUT') <input type="date" name="date" value="{{ $transaction->date }}" required>

        <input type="text" name="title" value="{{ $transaction->title }}" required>

        <select name="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="type" required>
            <option value="EXPENSE" {{ $transaction->type == 'EXPENSE' ? 'selected' : '' }}>รายจ่าย</option>
            <option value="INCOME" {{ $transaction->type == 'INCOME' ? 'selected' : '' }}>รายรับ</option>
        </select>

        <input type="number" name="amount" value="{{ $transaction->amount }}" step="0.01" required>

        <button type="submit">อัปเดตข้อมูล</button>
        <a href="/">ยกเลิก</a>
    </form>
</body>

</html>
