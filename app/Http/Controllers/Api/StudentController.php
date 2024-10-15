<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Passport;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::query()->latest('id')->paginate(5);
        return response()->json($data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // // Tạo mới sinh viên
        // $student = Student::create($request->only(['name', 'email', 'classroom_id']));

        // // Tạo hộ chiếu cho sinh viên
        // Passport::create([
        //     'student_id' => $student->id,
        //     'passport_number' => $request->passport_number,
        //     'issued_date' => $request->issued_date,
        //     'expiry_date' => $request->expiry_date,
        // ]);

        // // Gắn môn học cho sinh viên
        // $student->subjects()->sync($request->subjects);

        // return response()->json($student, 201); 
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
        $student = Student::with('classroom', 'passport', 'subjects')->find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Tìm sinh viên theo ID
    // $student = Student::find($id);
    // if (!$student) {
    //     return response()->json(['message' => 'Student not found'], 404);
    // }

    // // Cập nhật thông tin sinh viên
    // $student->update($request->only(['name', 'email', 'classroom_id']));

    // // Kiểm tra và cập nhật hộ chiếu (nếu có)
    // if ($student->passport) {
    //     $student->passport->update($request->only(['passport_number', 'issued_date', 'expiry_date']));
    // } else {
    //     // Nếu sinh viên chưa có hộ chiếu, tạo mới
    //     Passport::create([
    //         'student_id' => $student->id,
    //         'passport_number' => $request->passport_number,
    //         'issued_date' => $request->issued_date,
    //         'expiry_date' => $request->expiry_date,
    //     ]);
    // }

    // Đồng bộ môn học (chỉ đồng bộ nếu có subjects trong request)
    // if ($request->has('subjects')) {
    //     $student->subjects()->sync($request->subjects);
    // }

    // // Tải lại thông tin sinh viên kèm quan hệ
    // $student->load('passport', 'classroom', 'subjects');

    // // Trả về thông tin sinh viên đã được cập nhật
    // return response()->json($student);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
    
}
