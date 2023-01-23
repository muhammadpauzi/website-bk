<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private array $customAttributes = [
        'name' => 'Nama Lengkap Siswa',
        'nis' => 'NIS',
        'nisn' => 'NISN',
        'email' => 'Email',
        'gender' => 'Jenis Kelamin'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::query()
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('students.index', [
            'title' => 'Daftar Data Siswa',
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create', [
            'title' => 'Tambah Data Siswa'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'nis' => 'required|numeric|unique:students|digits:10',
            'nisn' => 'required|numeric|unique:students|digits:10',
            'email' => 'required|email',
            'gender' => 'required|in:l,p',
        ], customAttributes: $this->customAttributes);

        Student::create($validatedData);

        return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('students.show', [
            'title' => 'Detail Data Siswa',
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('students.edit', [
            'title' => 'Edit Data Siswa',
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $nisUniqueValidation = $request->nis === $student->nis ? '' : '|unique:students';
        $nisnUniqueValidation = $request->nisn === $student->nisn ? '' : '|unique:students';

        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'nis' => 'required|numeric|digits:10' . $nisUniqueValidation,
            'nisn' => 'required|numeric|digits:10' . $nisnUniqueValidation,
            'email' => 'required|email',
            'gender' => 'required|in:l,p',
        ], customAttributes: $this->customAttributes);

        $student->update($validatedData);

        return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
