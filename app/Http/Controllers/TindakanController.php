<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TindakanController extends Controller
{

    public static array $customAttributes = [
        'name' => 'Nama Lengkap Tindakan',
        'description' => 'Keterangan',
        'min_point' => 'Min. Poin',
        'max_point' => 'Max. Poin',
        'is_active' => 'Status Aktif'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tindakans = Tindakan::query()
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('tindakans.index', [
            'title' => 'Daftar Data Tindakan',
            'tindakans' => $tindakans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tindakans.create', [
            'title' => 'Tambah Data Tindakan'
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
            'min_point' => 'required|numeric|min:0',
            'max_point' => 'required|numeric|min:0'
        ], customAttributes: self::$customAttributes);

        Tindakan::create($validatedData);

        return redirect()
            ->route('tindakans.index')
            ->with('success', 'Data tindakan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function show(Tindakan $tindakan)
    {
        return view('tindakans.show', [
            'title' => 'Detail Data Tindakan',
            'tindakan' => $tindakan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tindakan $tindakan)
    {
        return view('tindakans.edit', [
            'title' => 'Edit Data Tindakan',
            'tindakan' => $tindakan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tindakan $tindakan)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'description' => 'max:512',
            'min_point' => 'required|numeric|min:0',
            'max_point' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1'
        ], customAttributes: self::$customAttributes);

        $tindakan->update(array_merge($validatedData, [
            'is_active' => boolval($validatedData['is_active'])
        ]));
        return redirect()
            ->route('tindakans.index')
            ->with('success', 'Data tindakan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tindakan $tindakan)
    {
        $tindakan->delete();

        return redirect()
            ->route('tindakans.index')
            ->with('success', 'Data tindakan berhasil dihapus.');
    }
}
