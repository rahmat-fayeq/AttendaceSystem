<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('pages.students.index', compact('students'));
    }

    public function create()
    {
        return view('pages.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_user_id' => 'nullable|integer|unique:students,device_user_id',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|unique:students,email',
        ]);

        $student = Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully!');
    }

    public function edit(Student $student)
    {
        return view('pages.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'device_user_id' => 'nullable|integer|unique:students,device_user_id,' . $student->id,
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|unique:students,email,' . $student->id,
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }
}
