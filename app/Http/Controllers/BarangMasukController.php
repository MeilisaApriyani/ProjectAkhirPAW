<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('stock')->get();
        $stocks = Stock::all();
        return view('barang-masuk', compact('barangMasuk', 'stocks'));
    }

    public function store(Request $request)
    {
        \Log::info('Data request: ', $request->all());

        $request->validate([
            'idbarang' => 'required|exists:stocks,idbarang',
            'penanggungjawab' => 'required|string',
            'jumlahmasuk' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $barangMasuk = new BarangMasuk();
            $barangMasuk->idbarang = $request->input('idbarang');
            $barangMasuk->namabarang = Stock::where('idbarang', $request->input('idbarang'))->value('namabarang');
            $barangMasuk->tanggalMasuk = now();
            $barangMasuk->penanggungjawab = $request->input('penanggungjawab');
            $barangMasuk->jumlahmasuk = $request->input('jumlahmasuk');
            $barangMasuk->created_at = now();
            $barangMasuk->updated_at = now();
            
            $stock = Stock::where('idbarang', $request->input('idbarang'))->first();
            if ($stock) {
                $barangMasuk->image = $stock->image;
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $barangMasuk->image = $filename;
            }

            $barangMasuk->save();

            $stock->jumlah += $request->input('jumlahmasuk');
            $stock->save();
        });

        return redirect()->route('barang-masuk')->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    public function update(Request $request, $idmasuk)
    {

        $request->validate([
            'idbarang' => 'required|exists:stocks,idbarang',
            'penanggungjawab' => 'required|string',
            'jumlahmasuk' => 'required|integer',
        ]);

        try {
            DB::transaction(function () use ($request, $idmasuk) {
                $barangMasuk = BarangMasuk::find($idmasuk);
                if (!$barangMasuk) {
                    throw new \Exception('Data tidak ditemukan.');
                }

                $stock = Stock::find($request->input('idbarang'));
                $stoksekarang = $stock->jumlah;

                $jumlahskrg = $barangMasuk->jumlahmasuk;

                if ($request->input('jumlahmasuk') > $jumlahskrg) {
                    $selisih = $request->input('jumlahmasuk') - $jumlahskrg;
                    $stokbaru = $stoksekarang + $selisih;
                } else {
                    $selisih = $jumlahskrg - $request->input('jumlahmasuk');
                    $stokbaru = $stoksekarang - $selisih;
                }

                if ($stokbaru < 0) {
                    throw new \Exception('Stock cannot be negative.');
                }

                $stock->jumlah = $stokbaru;
                $stock->save();

                $barangMasuk->idbarang = $request->input('idbarang');
                $barangMasuk->penanggungjawab = $request->input('penanggungjawab');
                $barangMasuk->jumlahmasuk = $request->input('jumlahmasuk');
                $barangMasuk->tanggalMasuk = now();

                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images'), $filename);
                    $barangMasuk->image = $filename;
                }

                $barangMasuk->save();
            });

            return redirect()->route('barang-masuk')->with('success', 'Data barang masuk berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->route('barang-masuk')->with('error', $e->getMessage());
        }
    }

    public function destroy($idmasuk)
    {
        try {
            DB::transaction(function () use ($idmasuk) {
                $barangMasuk = BarangMasuk::find($idmasuk);
                if (!$barangMasuk) {
                    throw new \Exception('Data tidak ditemukan.');
                }

                $idbarang = $barangMasuk->idbarang;
                $jumlahmasuk = $barangMasuk->jumlahmasuk;

                $stock = Stock::find($idbarang);
                $stock->jumlah -= $jumlahmasuk;
                $stock->save();

                $barangMasuk->delete();
            });

            return redirect()->route('barang-masuk')->with('success', 'Data barang masuk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('barang-masuk')->with('error', $e->getMessage());
        }
    }
}
