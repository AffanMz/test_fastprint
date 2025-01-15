<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorys';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];
}
