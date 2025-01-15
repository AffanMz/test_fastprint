<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_produk',
        'nama_produk',
        'harga',
        'id_kategori',
        'id_status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'id_status', 'id_status');
    }
}
