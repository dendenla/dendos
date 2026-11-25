<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    protected $fillable = [
        'nama_tempat',
        'kategori',
        'alamat',
        'link_google_maps',
        'catatan',
        'rentang_harga',
        'foto',
    ];
}
