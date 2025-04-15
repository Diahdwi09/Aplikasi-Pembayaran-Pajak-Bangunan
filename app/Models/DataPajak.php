<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPajak extends Model
{
    use HasFactory;

    // Menentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'nob',
        'name',
        'address_wajib_pajak',
        'address_objek_pajak',
        'jumlah',
    ];
}
