<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller    
{
    public function index()
    {
        $students = Student::paginate(10);

        $stud_list = ["Student ID", "First Name", "Last Name", "Email", "Course", "Year Level", "Actions"];
        return view('student', compact('stud_list', 'students'));
    }

    public function edit(string $student_id)
    {
        $student = Student::findOrFail($student_id);
        return view('edit', compact('student'));
    }

    public function update(Request $request, string $student_id)
    {
        $student = Student::findOrFail($student_id);
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email',
            'course'     => 'required',
            // Add other fields as necessary
        ]);
        $student->update($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully!'
        ]);
    }

    public function destroy(string $student_id) {
        $student = Student::findOrFail($student_id);
        $student->delete();
        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully!'
        ]);
    }
}
