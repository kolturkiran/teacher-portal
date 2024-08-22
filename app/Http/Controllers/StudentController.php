<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'marks' => 'required|integer',
        ]);

        $student = Student::where('name', $request->name)
                          ->where('subject', $request->subject)
                          ->first();

        if ($student) {
            $student->marks += $request->marks;
            $student->save();
        } else {
            Student::create($request->all());
        }

        return redirect()->route('students.index');
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'marks' => 'required|integer',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index');
    }
}

