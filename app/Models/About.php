<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $table = 'about';

    protected $fillable = [
        'deskripsi',
        'logo',
        'nama_author',
        'photo_author',
        'link_github',
        'quotes_author'
    ];
}
