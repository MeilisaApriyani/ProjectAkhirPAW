<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';
    protected $primaryKey = 'idkeluar';
    public $timestamps = true;
    protected $fillable = ['idbarang','namabarang', 'tanggalkeluar', 'keterangan', 'jumlahkeluar','image','created_at', 'updated_at'];

    
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'idbarang','idbarang');
    }
}
