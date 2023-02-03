<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Artikel extends Model
{
    use HasFactory;
    protected $table = 'artikel';

    protected $fillable = [
        'title',
        'author',
        'tanggal',
        'kategori_artikel_id',
        'thumbnail',
        'deskripsi'
    ];

    function delete_thumbnail()
    {
        if ($this->thumbnail && Storage::exists('public/artikel/thumbnail/' . $this->thumbnail))
            // Storage::disk('local')->delete('public/artikel/thumbnail/'.$this->thumbnail);
            Storage::delete('public/artikel/thumbnail/' . $this->thumbnail);
    }
}
