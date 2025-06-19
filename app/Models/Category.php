<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    // Lindungi kolom agar tidak bisa diisi sembarangan
    protected $guarded = ['id'];

    protected $fillable = [
        'type',
    ];
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}

