<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Devrabiul\ToastMagic\Facades\ToastMagic;

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
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:students,email',
        ]);

        Student::create($validated);

        ToastMagic::success(__('app.success'));

        return redirect()->route('students.index');
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
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:students,email,' . $student->id,
        ]);

        $student->update($validated);

        ToastMagic::info(__('app.info'));

        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        ToastMagic::warning(__('app.warning'));

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }
}
