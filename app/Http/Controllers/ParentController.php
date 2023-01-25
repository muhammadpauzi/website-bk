<?php

namespace App\Http\Controllers;

use App\Exports\ParentsTemplateExport;
use App\Imports\ParentsImport;
use App\Models\_Parent;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParentController extends Controller
{

    public static array $customAttributes = [
        'name' => 'Nama Orang Tua',
        'phone' => 'No. HP',
        'gender' => 'Jenis Kelamin',
        'alamat' => 'Alamat',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = _Parent::query()
            ->with([
                'students'
            ])
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('parents.index', [
            'title' => 'Daftar Data Orang Tua',
            'parents' => $parents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parents.create', [
            'title' => 'Tambah Data Orang Tua'
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
            'phone' => 'required|max:20',
            'alamat' => 'required|max:512',
            'gender' => 'required|in:l,p',
        ], customAttributes: self::$customAttributes);

        _Parent::create($validatedData);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\_Parent  $parent
     * @return \Illuminate\Http\Response
     */
    public function show(_Parent $parent)
    {
        $parent->load('students');

        return view('parents.show', [
            'title' => 'Detail Data Orang Tua',
            'parent' => $parent
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\_Parent  $parent
     * @return \Illuminate\Http\Response
     */
    public function edit(_Parent $parent)
    {
        return view('parents.edit', [
            'title' => 'Edit Data Orang Tua',
            'parent' => $parent
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\_Parent  $parent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, _Parent $parent)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'phone' => 'required|max:20',
            'alamat' => 'required|max:512',
            'gender' => 'required|in:l,p',
        ], customAttributes: self::$customAttributes);

        $parent->update($validatedData);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Data orang tua berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\_Parent  $parent
     * @return \Illuminate\Http\Response
     */
    public function destroy(_Parent $parent)
    {
        optional($parent->user())->delete();
        $parent->delete();

        return redirect()
            ->route('parents.index')
            ->with('success', 'Data orang tua berhasil dihapus.');
    }

    public function downloadTemplateExcel()
    {
        return Excel::download(new ParentsTemplateExport, 'TEMPLATE_KELAS.xlsx');
    }

    public function importTemplateExcel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,ods,odt,odp'
        ], customAttributes: [
            'file' => 'File Template Excel'
        ]);

        Excel::import(new ParentsImport, $request->file('file'));

        return redirect()
            ->route('parents.index')
            ->with('success', 'Data orang tua berhasil di-import.');
    }
}
