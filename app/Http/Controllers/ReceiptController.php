<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    // Method untuk menampilkan halaman struk
    public function print(Order $order)
    {
        // Mengirim data order ke view 'receipts.print'
        return view('receipts.print', compact('order'));
    }
}
