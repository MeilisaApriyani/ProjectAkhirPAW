<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $primaryKey = 'idbarang';
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'idbarang',
        'namabarang',
        'letakbarang',
        'jumlah',
        'harga',
        'image',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'idbarang', 'idbarang');
    }
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'idbarang', 'idbarang');
    }
}
