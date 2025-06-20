<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Stock;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('stock')->get();
        $stocks = Stock::all();
        return view('barang-keluar', compact('barangKeluar', 'stocks'));
    }

    public function store(Request $request)
    {
        \Log::info('Data request: ', $request->all());

        $request->validate([
            'idbarang' => 'required|exists:stocks,idbarang',
            'keterangan' => 'required|string',
            'jumlahkeluar' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $stock = Stock::where('idbarang', $request->input('idbarang'))->first();
        if ($stock && $stock->jumlah < $request->input('jumlahkeluar')) {
            return redirect()->back()->withErrors(['error' => 'Jumlah barang keluar melebihi stok yang tersedia.']);
        }

        $barangKeluar = new BarangKeluar();
        $barangKeluar->idbarang = $request->input('idbarang');
        $barangKeluar->namabarang = $stock->namabarang;
        $barangKeluar->tanggalkeluar = now();
        $barangKeluar->keterangan = $request->input('keterangan');
        $barangKeluar->jumlahkeluar = $request->input('jumlahkeluar');
        $barangKeluar->created_at = now();
        $barangKeluar->updated_at = now();
        
        if ($stock) {
            $barangKeluar->image = $stock->image;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $barangKeluar->image = $filename;
        }

        $barangKeluar->save();

        $stock->jumlah -= $request->input('jumlahkeluar');
        $stock->save();

        return redirect()->route('barang-keluar')->with('success', 'Data barang keluar berhasil ditambahkan.');
    }

    public function update(Request $request, $idkeluar)
    {
        $request->validate([
            'idbarang' => 'required|exists:stocks,idbarang',
            'jumlahkeluar' => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        $barangKeluar = BarangKeluar::find($idkeluar);
        if (!$barangKeluar) {
            return redirect()->route('barang-keluar')->with('error', 'Data tidak ditemukan.');
        }

        $stock = Stock::where('idbarang', $request->input('idbarang'))->first();
        $jumlahskrg = $barangKeluar->jumlahkeluar;
        $jumlahkeluar = $request->input('jumlahkeluar');

        if ($jumlahkeluar > $jumlahskrg && $stock->jumlah < ($jumlahkeluar - $jumlahskrg)) {
            return redirect()->back()->withErrors(['error' => 'Jumlah barang keluar melebihi stok yang tersedia.']);
        }

        if ($jumlahkeluar > $jumlahskrg) {
            $selisih = $jumlahkeluar - $jumlahskrg;
            $stock->jumlah -= $selisih;
        } else {
            $selisih = $jumlahskrg - $jumlahkeluar;
            $stock->jumlah += $selisih;
        }

        $barangKeluar->jumlahkeluar = $jumlahkeluar;
        $barangKeluar->keterangan = $request->input('keterangan');
        $barangKeluar->tanggalkeluar = now();
        if ($stock) {
            $barangKeluar->image = $stock->image;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $barangKeluar->image = $filename;
        }

        $barangKeluar->save();
        $stock->save();

        return redirect()->route('barang-keluar')->with('success', 'Data barang keluar berhasil diupdate.');
    }

    public function destroy(Request $request, $idkeluar)
    {
        $barangKeluar = BarangKeluar::find($idkeluar);
        if (!$barangKeluar) {
            return redirect()->route('barang-keluar')->with('error', 'Data tidak ditemukan.');
        }

        $stock = Stock::where('idbarang', $barangKeluar->idbarang)->first();
        if ($stock) {
            $stock->jumlah += $barangKeluar->jumlahkeluar;
            $stock->save();
        }

        $barangKeluar->delete();

        return redirect()->route('barang-keluar')->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
