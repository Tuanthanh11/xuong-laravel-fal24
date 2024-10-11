@extends('admin.master')
@section('title')
    Danh sach Hoc sinh
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh sách sinh viên</h1>

        <a href="{{ route('students.create') }}" class="btn btn-primary">Thêm sinh viên</a>

        
    </div>
    @if (session()->has('success') && session()->get('success'))
            <div class="alert alert-success">
                Thao tac thanh cong
            </div>
        @endif

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger">
            {{ $session->get('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Hộ chiếu</th>
                <th>Lớp học</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->passport->passport_number ?? 'Không có' }}</td>
                    <td>{{ $student->classroom->name }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
@endsection
