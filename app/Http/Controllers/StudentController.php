<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller    
{
    // index(): Kukuha ito ng listahan ng mga estudyante mula sa database gamit ang
    public function index()
    {
        // paginate(10) (hinahati ang resulta para magpakita ng 10 estudyante bawat pahina). Ipapasa nito ang mga data na ito, 
        // kasama ang mga column headers ($stud_list), papunta sa student view para ma-display sa screen.

        $students = Student::paginate(10);

        $stud_list = ["Student ID", "First Name", "Last Name", "Email", "Course", "Year Level", "Actions"];
        return view('student', compact('stud_list', 'students'));
    }

    // edit($student_id): Hahanapin nito ang isang partikular na record ng estudyante gamit ang ID (findOrFail). 
    // Kapag nakita, ipapasa nito ang data ng estudyanteng iyon papunta sa edit view upang mailagay sa isang form na pwedeng baguhin.
    public function edit(string $student_id)
    {
        $student = Student::findOrFail($student_id);
        return view('edit', compact('student'));
    }

    // update(Request $request, string $student_id): Dito napupunta ang bagong impormasyon kapag sinubmit mo ang edit form. 
    // Dadaan muna ang data sa $request->validate para siguraduhing kumpleto at tama ang format (halimbawa, dapat balido ang email format). 
    // Kapag pumasa sa validation, isa-save nito ang pagbabago sa database at magbabalik ng JSON response bilang kumpirmasyon.
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
