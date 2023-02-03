<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaraBelanja extends Model
{
    use HasFactory;
    protected $table = 'cara_belanja';
    protected $fillable = ['title', 'deskripsi'];
}
