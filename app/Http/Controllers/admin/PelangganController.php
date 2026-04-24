<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pelanggan::all();
        return view('admin.pelanggan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_nama' => 'required',
            'pelanggan_wa' => 'nullable'
        ]);

        $pelanggan = Pelanggan::create($request->all());

        // 🔥 TAMBAHAN LOGIKA REDIRECT
        if ($request->redirect == 'transaksi') {
            return redirect('/admin/transaksi/create?pelanggan_id='.$pelanggan->pelanggan_id)
                ->with('success','Pelanggan berhasil ditambahkan');
        }

        return redirect('/admin/pelanggan')->with('success','Data berhasil ditambah');
    }
    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'pelanggan_nama' => 'required',
            'pelanggan_wa' => 'nullable'
        ]);

        $pelanggan->update($request->all());

        return redirect('/admin/pelanggan')->with('success','Data berhasil diupdate');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return back()->with('success','Data berhasil dihapus');
    }
}
