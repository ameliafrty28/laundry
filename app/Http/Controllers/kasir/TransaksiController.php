<?php

namespace App\Http\Controllers\kasir;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::with(['pelanggan','detail.layanan'])->latest()->get();
        return view('kasir.transaksi.index', compact('data'));
    }

    public function create(Request $request)
    {
        $pelanggan = Pelanggan::all();
        $layanan = Layanan::all();

        return view('kasir.transaksi.create', [
            'pelanggan' => $pelanggan,
            'layanan' => $layanan,
            'selectedPelanggan' => $request->pelanggan_id
        ]);
    }

    // ======================
    // STEP 1 → PROSES KE PEMBAYARAN
    // ======================
    public function proses(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'transaksi_tanggal' => 'required|date'
        ]);

        $total = 0;
        $detail = [];

        foreach ($request->layanan_id as $i => $layanan_id) {

            $layanan = Layanan::find($layanan_id);

            $qty = $request->qty[$i] ?? 0;
            $berat = $request->berat[$i] ?? 0;

            $jumlah = $berat > 0 ? $berat : $qty;

            if ($jumlah <= 0) continue;

            $subtotal = $layanan->layanan_harga * $jumlah;
            $total += $subtotal;

            $detail[] = [
                'layanan_id' => $layanan_id,
                'nama' => $layanan->layanan_nama,
                'harga' => $layanan->layanan_harga,
                'qty' => $qty,
                'berat' => $berat,
                'subtotal' => $subtotal
            ];
        }

        return view('kasir.transaksi.pembayaran', [
            'pelanggan_id' => $request->pelanggan_id,
            'transaksi_tanggal' => $request->transaksi_tanggal, // 🔥 penting
            'detail' => $detail,
            'total' => $total
        ]);
    }

    // ======================
    // STEP 2 → SIMPAN DATABASE
    // ======================
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $total = $request->total;
            $mode = $request->mode_bayar;

            if ($mode == 'sekarang') {

                $inputBayar = $request->dibayar ?? 0;

                if ($inputBayar >= $total) {
                    $dibayar = $total;
                    $sisa = 0;
                    $status = 'lunas';
                } else {
                    $dibayar = $inputBayar;
                    $sisa = $total - $inputBayar;
                    $status = 'belum_lunas';
                }

            } else {
                $dibayar = 0;
                $sisa = $total;
                $status = 'belum_lunas';
            }

            $request->validate([
                'pelanggan_id' => 'required',
                'transaksi_tanggal' => 'required|date'
            ]);

            $transaksi = Transaksi::create([
                'user_id' => auth()->user()->user_id ?? 1,
                'pelanggan_id' => $request->pelanggan_id,
                'transaksi_tanggal' => $request->transaksi_tanggal, // 🔥 FIX
                'transaksi_total' => $total,
                'transaksi_dibayar' => $dibayar,
                'transaksi_sisa' => $sisa,
                'transaksi_status_pembayaran' => $status,
                'transaksi_metode_pembayaran' => $mode == 'sekarang' ? $request->metode : null,
                'transaksi_status_pesanan' => 'proses'
            ]);

            foreach ($request->layanan_id as $i => $id) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'layanan_id' => $id,
                    'detail_qty' => $request->qty[$i],
                    'detail_berat' => $request->berat[$i],
                    'detail_subtotal' => $request->subtotal[$i]
                ]);
            }

            DB::commit();

            return redirect('/kasir/transaksi')->with('success','Transaksi berhasil');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Transaksi::with(['pelanggan','detail.layanan'])
            ->findOrFail($id);

        return view('kasir.transaksi.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Transaksi::with('pelanggan')->findOrFail($id);

        return view('kasir.transaksi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Transaksi::findOrFail($id);

        $dibayar = $request->dibayar ?? $data->transaksi_dibayar;

        // total tetap
        $total = $data->transaksi_total;

        // hitung ulang
        if ($dibayar >= $total) {
            $status_bayar = 'lunas';
            $sisa = 0;
            $dibayar = $total; // 🔥 penting
        } else {
            $status_bayar = 'belum_lunas';
            $sisa = $total - $dibayar;
        }

        $data->update([
            'transaksi_dibayar' => $dibayar,
            'transaksi_sisa' => $sisa,
            'transaksi_status_pembayaran' => $status_bayar,
            'transaksi_status_pesanan' => $request->status_pesanan
        ]);

        return redirect('/kasir/transaksi')->with('success','Transaksi berhasil diupdate');
    }

    public function bayar($id)
    {
        $data = Transaksi::with('pelanggan')->findOrFail($id);

        return view('kasir.transaksi.bayar', compact('data'));
    }

    public function prosesBayar(Request $request, $id)
    {
        $data = Transaksi::findOrFail($id);

        $bayar = $request->dibayar;

        // total dibayar sebelumnya + input baru
        $totalDibayar = $data->transaksi_dibayar + $bayar;

        $total = $data->transaksi_total;

        if ($totalDibayar >= $total) {
            $dibayar = $total;
            $sisa = 0;
            $status = 'lunas';
        } else {
            $dibayar = $totalDibayar;
            $sisa = $total - $totalDibayar;
            $status = 'belum_lunas';
        }

        $data->update([
            'transaksi_dibayar' => $dibayar,
            'transaksi_sisa' => $sisa,
            'transaksi_status_pembayaran' => $status,
            'transaksi_metode_pembayaran' => $request->metode
        ]);

        return redirect('/kasir/transaksi')->with('success','Pembayaran berhasil');
    }
public function destroy($id)
{
    $transaksi = Transaksi::findOrFail($id);
    $transaksi->delete();

    return redirect()->route('kasir.transaksi.index')
        ->with('success', 'Transaksi berhasil dihapus (sementara)');
}
}