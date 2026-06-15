<?php

namespace App\Http\Controllers;

use App\Models\StudentManagement;
use Illuminate\Http\Request;

class StudentManagementController extends Controller
{
    public function index()
    {
        $students = StudentManagement::orderBy('id', 'desc')->get();

        return view('students.list', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'integer', 'regex:/^[1-9][0-9]*$/'],
        ], [
            'student_id.regex' => "Student ID can't start with number 0",
        ]);

        StudentManagement::create($validated);

        return redirect()->route('students.index');
    }

    public function show(string $id)
    {
        $student = StudentManagement::findOrFail($id);

        return view('students.show', compact('student'));
    }

    public function edit(string $id)
    {
        $student = StudentManagement::findOrFail($id);

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, string $id)
    {
        $student = StudentManagement::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'integer', 'regex:/^[1-9][0-9]*$/'],
        ], [
            'student_id.regex' => "Student ID can't start with number 0",
        ]);

        $student->update($validated);

        return redirect()->route('students.index');
    }

    public function destroy(string $id)
    {
        $student = StudentManagement::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index');
    }
}
