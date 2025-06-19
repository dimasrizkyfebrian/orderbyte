<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    // Lindungi kolom agar tidak bisa diisi sembarangan
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    { 
        return $this->hasMany(Review::class);
    }

    // Helper untuk menghitung rata-rata rating
    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
