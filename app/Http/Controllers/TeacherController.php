<?php

namespace App\Http\Controllers;

use App\Exports\TeachersTemplateExport;
use App\Imports\TeachersImport;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{

    public static array $customAttributes = [
        'name' => 'Nama Lengkap Guru',
        'nip' => 'NIP',
        'email' => 'Email',
        'gender' => 'Jenip Kelamin'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()
            ->with(['user'])
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('teachers.index', [
            'title' => 'Daftar Data Guru',
            'teachers' => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.create', [
            'title' => 'Tambah Data Guru'
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
            'nip' => 'required|numeric|unique:teachers|digits:18',
            'email' => 'required|email',
            'gender' => 'required|in:l,p',
        ], customAttributes: self::$customAttributes);

        Teacher::create($validatedData);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('teachers.show', [
            'title' => 'Detail Data Guru',
            'teacher' => $teacher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', [
            'title' => 'Edit Data Guru',
            'teacher' => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $nipUniqueValidation = $request->nip === $teacher->nip ? '' : '|unique:teachers';

        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'nip' => 'required|numeric|digits:18' . $nipUniqueValidation,
            'email' => 'required|email',
            'gender' => 'required|in:l,p',
        ], customAttributes: self::$customAttributes);

        $teacher->update($validatedData);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Data guru berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        optional($teacher->user())->delete();
        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function downloadTemplateExcel()
    {
        return Excel::download(new TeachersTemplateExport, 'TEMPLATE_GURU.xlsx');
    }

    public function importTemplateExcel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,ods,odt,odp'
        ], customAttributes: [
            'file' => 'File Template Excel'
        ]);

        Excel::import(new TeachersImport, $request->file('file'));

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Data guru berhasil di-import.');
    }
}
