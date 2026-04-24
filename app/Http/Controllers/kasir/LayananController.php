<?php

namespace App\Http\Controllers\kasir;

use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Layanan::all();
        return view('kasir.layanan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kasir.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'layanan_nama' => 'required',
            'layanan_jenis' => 'required|in:Reguler,Satuan,Ekspres',
            'layanan_harga' => 'required|numeric'
        ]);

        Layanan::create($request->all());

        return redirect('/kasir/layanan')->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('kasir.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'layanan_nama' => 'required',
            'layanan_jenis' => 'required|in:Reguler,Satuan,Ekspres',
            'layanan_harga' => 'required|numeric'
        ]);

        $layanan->update($request->all());

        return redirect('/kasir/layanan')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect('/kasir/layanan')->with('success', 'Data berhasil dihapus');
    }
}
