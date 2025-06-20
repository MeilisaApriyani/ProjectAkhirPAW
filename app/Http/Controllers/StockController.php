<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('dashboard', compact('stocks'));
    }

    public function user(){
        $stocks = Stock::all();
        return view('user', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idbarang' => 'required|string|max:255|unique:stocks,idbarang',
            'namabarang' => 'required|string|max:255',
            'letakbarang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        $stock = new Stock();
        $stock->idbarang = $request->idbarang;
        $stock->namabarang = $request->namabarang;
        $stock->letakbarang = $request->letakbarang;
        $stock->jumlah = $request->jumlah;
        $stock->harga = $request->harga;
        if ($request->hasFile('file')) {
            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images'), $imageName);
            $stock->image = $imageName;
        }

        $stock->save();

        return redirect()->route('dashboard')->with('success', 'Data Barang berhasil ditambahkan');
    }
    
        

    public function update(Request $request, $idbarang)
    {
        $request->validate([
            'namabarang' => 'required|string|max:255',
            'letakbarang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $stock = Stock::findOrFail($idbarang);
        $stock->namabarang = $request->namabarang;
        $stock->letakbarang = $request->letakbarang;
        $stock->jumlah = $request->jumlah;
        $stock->harga = $request->harga;

        if ($request->hasFile('file')) {
            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images'), $imageName);
            $stock->image = $imageName;
        }

        $stock->save();
       
        BarangMasuk::where('idbarang', $stock->idbarang)->update([
            'namabarang' => $stock->namabarang,
            'image' => $stock->image
        ]);
        
       
        BarangKeluar::where('idbarang', $stock->idbarang)->update([
            'namabarang' => $stock->namabarang,
            'image' => $stock->image
        ]);

        return redirect()->route('dashboard')->with('success', 'Stock berhasil diperbarui');
    }

    public function destroy($idbarang)
    {
    $stock = Stock::where('idbarang', $idbarang)->first();

    if ($stock) {
        $stock->delete();
        return redirect()->route('dashboard')->with('success', 'Barang berhasil dihapus');
    } else {
        return redirect()->route('dashboard')->with('error', 'Barang tidak ditemukan');
    }
    }
    
}

