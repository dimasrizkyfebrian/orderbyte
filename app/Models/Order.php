<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    // Lindungi kolom agar tidak bisa diisi sembarangan
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        // Method 'creating' akan berjalan TEPAT SEBELUM sebuah order baru disimpan ke database
        static::creating(function (Order $order) {
            // Format: ORD-TahunBulanTanggal-4KarakterAcak
            $prefix = 'ORD-';
            $date = now()->format('ymd');

            // Loop untuk memastikan nomor yang dihasilkan benar-benar unik
            do {
                $random = Str::upper(Str::random(4));
                $number = $prefix . $date . '-' . $random;
            } while (self::where('order_number', $number)->exists()); // Cek ke database apakah nomor sudah ada

            // Assign nomor unik ke order
            $order->order_number = $number;
        });
    }

    /**
     * Relasi ke OrderItem (satu order punya banyak item).
     * Nama method 'items' (plural) karena hasilnya banyak.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke User (satu order dimiliki oleh satu user).
     * Nama method 'user' (singular) karena hasilnya satu.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Table (satu order menempati satu meja).
     * Nama method 'table' (singular) karena hasilnya satu.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
