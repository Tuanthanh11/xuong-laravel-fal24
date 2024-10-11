@extends('admin.master')
@section('title')
    Chi tiết khach hang : {{ $student->name }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Chi tiết sinh viên</h2>
        </div>
        <div class="card-body">
            <p><strong>Tên:</strong> {{ $student->name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Lớp học:</strong> {{ $student->classroom->name }}</p>
            <hr>

            <h3>Thông tin hộ chiếu</h3>
            @if($student->passport)
                <p><strong>Số hộ chiếu:</strong> {{ $student->passport->passport_number }}</p>
                <p><strong>Ngày cấp:</strong> {{ $student->passport->issued_date }}</p>
                <p><strong>Ngày hết hạn:</strong> {{ $student->passport->expiry_date }}</p>
            @else
                <p>Không có thông tin hộ chiếu</p>
            @endif
            <hr>

            <h3>Môn học đã đăng ký</h3>
            <ul class="list-group">
                @foreach($student->subjects as $subject)
                    <li class="list-group-item">{{ $subject->name }} ({{ $subject->credits }} tín chỉ)</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection