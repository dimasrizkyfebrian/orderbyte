<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Menu (satu item merujuk ke satu menu).
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
