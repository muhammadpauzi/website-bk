<?php

namespace App\Http\Controllers;

use App\Models\OffenseCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OffenseCategoryController extends Controller
{

    public static array $customAttributes = [
        'name' => 'Nama Kategori Pelanggaran',
        'description' => 'Keterangan',
        'point' => 'Poin',
        'is_active' => 'Status Aktif'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offenseCategories = OffenseCategory::query()
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('offense-categories.index', [
            'title' => 'Daftar Data Kategori Pelanggaran',
            'offenseCategories' => $offenseCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offense-categories.create', [
            'title' => 'Tambah Data Kategori Pelanggaran'
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
            'description' => 'max:512',
            'point' => 'required|numeric|min:0'
        ], customAttributes: self::$customAttributes);

        OffenseCategory::create($validatedData);

        return redirect()
            ->route('offense-categories.index')
            ->with('success', 'Data kategori pelanggaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OffenseCategory  $offenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(OffenseCategory $offenseCategory)
    {
        return view('offense-categories.show', [
            'title' => 'Detail Data Kategori Pelanggaran',
            'offenseCategory' => $offenseCategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OffenseCategory  $offenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(OffenseCategory $offenseCategory)
    {
        return view('offense-categories.edit', [
            'title' => 'Edit Data Kategori Pelanggaran',
            'offenseCategory' => $offenseCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OffenseCategory  $offenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OffenseCategory $offenseCategory)
    {

        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'description' => 'max:512',
            'point' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1'
        ], customAttributes: self::$customAttributes);

        $offenseCategory->update(array_merge($validatedData, [
            'is_active' => boolval($validatedData['is_active'])
        ]));

        return redirect()
            ->route('offense-categories.index')
            ->with('success', 'Data kategori pelanggaran berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OffenseCategory  $offenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(OffenseCategory $offenseCategory)
    {
        $offenseCategory->delete();

        return redirect()
            ->route('offense-categories.index')
            ->with('success', 'Data kategori pelanggaran berhasil dihapus.');
    }
}
