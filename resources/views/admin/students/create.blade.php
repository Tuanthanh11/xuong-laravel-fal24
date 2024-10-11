@extends('admin.master')
@section('title')
    Create
@endsection
@section('content')
    <h1>{{ isset($student) ? 'Chỉnh sửa sinh viên' : 'Thêm sinh viên mới' }}</h1>


    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger">
            {{ $session->get('success') }}
        </div>
    @endif

    <form action="{{ isset($student) ? route('students.update', $student->id) : route('students.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên sinh viên</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($student) ? $student->name : '' }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ isset($student) ? $student->email : '' }}" required>
        </div>

        <div class="mb-3">
            <label for="classroom_id" class="form-label">Lớp học</label>
            <select class="form-select" id="classroom_id" name="classroom_id" required>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ isset($student) && $classroom->id == $student->classroom_id ? 'selected' : '' }}>
                        {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="passport_number" class="form-label">Số hộ chiếu</label>
            <input type="text" class="form-control" id="passport_number" name="passport_number" value="{{ isset($student->passport) ? $student->passport->passport_number : '' }}">
        </div>

        <div class="mb-3">
            <label for="issued_date" class="form-label">Ngày cấp hộ chiếu</label>
            <input type="date" class="form-control" id="issued_date" name="issued_date" value="{{ isset($student->passport) ? $student->passport->issued_date : '' }}">
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Ngày hết hạn hộ chiếu</label>
            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ isset($student->passport) ? $student->passport->expiry_date : '' }}">
        </div>

        <div class="mb-3">
            <label for="subject_ids" class="form-label">Môn học</label>
            <select class="form-select" id="subject_ids" name="subject_ids[]" multiple required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ isset($student) && $student->subjects->contains($subject->id) ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($student) ? 'Cập nhật' : 'Lưu' }}</button>
    </form>
@endsection