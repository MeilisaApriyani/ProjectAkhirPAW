<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';
    protected $primaryKey = 'idmasuk';
    public $timestamps = true;
    protected $fillable = ['idbarang', 'namabarang', 'tanggalMasuk', 'penanggungjawab', 'jumlahmasuk', 'image', 'created_at', 'updated_at'];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'idbarang', 'idbarang');
    }
}


