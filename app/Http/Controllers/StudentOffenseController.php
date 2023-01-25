<?php

namespace App\Http\Controllers;

use App\Models\OffenseCategory;
use App\Models\Student;
use App\Models\StudentOffense;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentOffenseController extends Controller
{

    public static array $customAttributes = [
        'student_id' => 'Siswa',
        'reporter_id' => 'Pelapor (Guru)',
        'offense_category_id' => 'Kategori Pelanggaran',
        'reported_at' => 'Dilaporkan pada',
        'description' => 'Keterangan'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentOffenses = StudentOffense::query()
            ->with(['student', 'reporter', 'offenseCategory'])
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('student-offenses.index', [
            'title' => 'Daftar Data Pelanggaran Siswa',
            'studentOffenses' => $studentOffenses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student-offenses.create', [
            'title' => 'Tambah Data Pelanggaran Siswa',
            'students' => Student::query()
                ->orderBy('name', 'asc')
                ->select(['id', 'name', 'nis', 'nisn'])
                ->get(),
            'teachers' => Teacher::query()
                ->orderBy('name', 'asc')
                ->select(['id', 'name', 'nip'])
                ->get(),
            'offenseCategories' => OffenseCategory::query()
                ->orderBy('name', 'asc')
                ->select(['id', 'name', 'point'])
                ->get()
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
        /**
         * 1. Sebaiknya pada create pelanggaran, data siswa boleh multiple, tapi tetap menggunakan multiple     category
         * 2. Atau tetap menggunakan cara seperti, siswa hanya boleh satu, dan untuk kategori nya, boleh multiple dan menggunakan table pivot tersebut
         */
        $validatedData = $this->validate($request, [
            'student_id' => 'required|numeric',
            'reporter_id' => 'required|numeric',
            'offense_category_id' => 'required|numeric',
            'reported_at' => 'sometimes|date|nullable',
            'description' => 'max:2000',
        ], customAttributes: self::$customAttributes);

        $validatedData['reported_at'] = $validatedData['reported_at'] ?? today();

        StudentOffense::create($validatedData);

        return redirect()
            ->route('student-offenses.index')
            ->with('success', 'Data pelanggaran siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentOffense  $studentOffense
     * @return \Illuminate\Http\Response
     */
    public function show(StudentOffense $studentOffense)
    {
        return view('student-offenses.show', [
            'title' => 'Detail Data Pelanggaran Siswa',
            'pelanggaran siswa' => $studentOffense
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentOffense  $studentOffense
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentOffense $studentOffense)
    {
        return view('student-offenses.edit', [
            'title' => 'Edit Data Pelanggaran Siswa',
            'pelanggaran siswa' => $studentOffense
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentOffense  $studentOffense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentOffense $studentOffense)
    {
        $validatedData = $this->validate($request, [
            'student_id' => 'required|numeric',
            'reporter_id' => 'required|numeric',
            'offense_category_id' => 'required|numeric',
            'reported_at' => 'sometimes|date|nullable',
            'description' => 'max:2000',
        ], customAttributes: self::$customAttributes);

        $studentOffense->update($validatedData);

        return redirect()
            ->route('student-offenses.index')
            ->with('success', 'Data pelanggaran siswa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentOffense  $studentOffense
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentOffense $studentOffense)
    {
        $studentOffense->delete();

        return redirect()
            ->route('student-offenses.index')
            ->with('success', 'Data pelanggaran siswa berhasil dihapus.');
    }
}
