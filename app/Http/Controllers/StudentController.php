<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    const PATH_VIEW = 'admin.students.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::query()->latest('id')->paginate(5);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        $student = Student::create($request->only('name', 'email', 'classroom_id'));

        // Lưu hộ chiếu
        if ($request->passport_number) {
            $student->passport()->create([
                'passport_number' => $request->passport_number,
                'issued_date' => $request->issued_date,
                'expiry_date' => $request->expiry_date,
            ]);
        }

        // Gán môn học cho sinh viên
        $student->subjects()->attach($request->subject_ids);

        return redirect()->route('students.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::with('passport', 'subjects')->findOrFail($id);
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('student', 'classrooms', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $student = Student::findOrFail($id);
    $student->update($request->only('name', 'email', 'classroom_id'));

    if ($student->passport) {
        $student->passport->update([
            'passport_number' => $request->passport_number,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
        ]);
    } else if ($request->passport_number) {
        $student->passport()->create([
            'passport_number' => $request->passport_number,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
        ]);
    }

    $student->subjects()->sync($request->subject_ids);

    return redirect()->back()->with('success', 'Sinh viên đã được cập nhật thành công');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $student = Student::findOrFail($id);

    if ($student->passport) {
        $student->passport->delete();
    }
    $student->subjects()->detach();
    $student->delete();
    return redirect()->route('students.index')->with('success',true);
}
}
