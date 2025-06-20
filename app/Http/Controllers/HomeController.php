<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function home(Request $request)
    { 
      $selected_year = $request->query('year', Carbon::now()->year);

      $total_per_bulan = DB::table('barang_keluars')
          ->selectRaw('MONTH(tanggalkeluar) AS bulan, SUM(jumlahkeluar) AS total_per_bulan')
          ->whereYear('tanggalkeluar', $selected_year)
          ->where('keterangan', 'dibeli')
          ->groupBy('bulan')
          ->pluck('total_per_bulan', 'bulan')
          ->toArray();

      $bulan = array_fill(0, 12, 0);
      $jumlah_total_per_bulan = array_fill(0, 12, 0);

      foreach ($total_per_bulan as $index => $value) {
          $bulan_index = $index - 1;
          $jumlah_total_per_bulan[$bulan_index] = $value;
      }

      $years = DB::table('barang_keluars')
          ->selectRaw('DISTINCT YEAR(tanggalkeluar) AS tahun')
          ->orderBy('tahun', 'desc')
          ->pluck('tahun')
          ->toArray();

      return view('Home', [
          'bulan' => $bulan,
          'jumlah_total_per_bulan' => $jumlah_total_per_bulan,
          'selected_year' => $selected_year,
          'years' => $years,
      ]);
  }
}