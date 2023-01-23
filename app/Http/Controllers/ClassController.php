<?php

namespace App\Http\Controllers;

use App\Exports\ClassesTemplateExport;
use App\Imports\ClassesImport;
use App\Models\Class_;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClassController extends Controller
{

    public static array $customAttributes = [
        'name' => 'Nama Kelas',
        'wali_kelas_id' => 'Kelas Wali Kelas',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Class_::query()
            ->with([
                'waliKelas',
                'students' => fn (HasMany $query) => $query->orderBy('name', 'asc')
            ])
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('classes.index', [
            'title' => 'Daftar Data Kelas',
            'classes' => $classes,
            'teachers' => Teacher::query()
                ->orderBy('name', 'asc')
                ->get(),
            'allClasses' => Class_::select(['id', 'name'])->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classes.create', [
            'title' => 'Tambah Data Kelas',
            'teachers' => Teacher::query()
                ->orderBy('name', 'asc')
                ->get(),
            'students' => Student::query()
                ->whereDoesntHave('class')
                ->orderBy('name', 'asc')
                ->get(),
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
            'name' => 'required|max:128|unique:classes,name',
            'wali_kelas_id' => 'required|numeric',
            'student_ids' => 'array',
            'student_ids.*' => 'numeric'
        ], customAttributes: self::$customAttributes);

        $class = Class_::create($validatedData);

        if (array_key_exists('student_ids', $validatedData))
            Student::query()
                ->whereIn('id', $validatedData['student_ids'])
                ->update([
                    'class_id' => $class->id
                ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Class_  $class
     * @return \Illuminate\Http\Response
     */
    public function show(Class_ $class)
    {
        $class->load([
            'students' => fn (HasMany $students) => $students->orderBy('name', 'asc'),
            'waliKelas'
        ]);
        return view('classes.show', [
            'title' => 'Detail Data Kelas',
            'class' => $class
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Class_  $class
     * @return \Illuminate\Http\Response
     */
    public function edit(Class_ $class)
    {
        $class->load('students');

        return view('classes.edit', [
            'title' => 'Edit Data Kelas',
            'class' => $class,
            'teachers' => Teacher::query()
                ->orderBy('name', 'asc')
                ->get(),
            'students' => Student::query()
                ->where('class_id', null)
                ->orWhere('class_id', $class->id)
                ->orderBy('name', 'asc')
                ->get(),
            'studentIds' => $class->students->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Class_  $class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Class_ $class)
    {
        $classUniqueValidation = $request->name === $class->name ? '' : '|unique:classes,name';

        $validatedData = $this->validate($request, [
            'name' => 'required|max:128' . $classUniqueValidation,
            'wali_kelas_id' => 'required|numeric',
            'student_ids' => 'array',
            'student_ids.*' => 'numeric'
        ], customAttributes: self::$customAttributes);

        $class->update($validatedData);

        Student::query()
            ->where('class_id', $class->id)
            ->update([
                'class_id' => null
            ]);

        if (array_key_exists('student_ids', $validatedData))
            Student::query()
                ->whereIn('id', $validatedData['student_ids'])
                ->update([
                    'class_id' => $class->id
                ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Class_  $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(Class_ $class)
    {
        $class->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }

    public function downloadTemplateExcel()
    {
        return Excel::download(new ClassesTemplateExport, 'TEMPLATE_KELAS.xlsx');
    }

    public function importTemplateExcel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,ods,odt,odp'
        ], customAttributes: [
            'file' => 'File Template Excel'
        ]);

        Excel::import(new ClassesImport, $request->file('file'));

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil di-import.');
    }

    public function pindahKelasSiswa(Request $request)
    {
        $validatedData = $this->validate($request, [
            'dari_kelas_id' => 'required|numeric',
            'pindah_ke_kelas_id' => 'required|numeric'
        ], customAttributes: [
            'dari_kelas_id' => 'Dari Kelas',
            'pindah_ke_kelas_id' => 'Pindah ke Kelas'
        ]);

        Student::query()
            ->where('class_id', $validatedData['dari_kelas_id'])
            ->update([
                'class_id' => $validatedData['pindah_ke_kelas_id']
            ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data siswa berhasil dipindah kelaskan.');
    }
}
