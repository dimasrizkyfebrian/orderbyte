<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;
use App\Events\OrderPaidEvent;
use Illuminate\Support\Facades\Auth;

class KasirView extends Component
{
    public $unpaidOrders;
    public $readyOrders; // <-- PROPERTI BARU untuk pesanan yang siap disajikan
    public $selectedOrder;

    public function mount()
    {
        $this->loadOrders();
    }
    
    // Method baru untuk memuat semua order yang dibutuhkan
    public function loadOrders()
    {
        $this->unpaidOrders = Order::where('status', 'menunggu_pembayaran')
                                ->with('items.menu', 'table', 'user')
                                ->latest()
                                ->get();
                                
        $this->readyOrders = Order::where('status', 'siap_disajikan')
                                ->with('table', 'user')
                                ->latest()
                                ->get();
    }

    public function selectOrder($orderId)
    {
        $this->selectedOrder = Order::with('items.menu', 'table', 'user')->find($orderId);
    }

    public function confirmPayment($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) { return; }

        $order->status = 'diproses';
        $order->save();

        // event(new OrderPaidEvent($order)); // Tetap nonaktif untuk saat ini

        $this->loadOrders(); // Muat ulang kedua daftar
        $this->selectedOrder = null;
        session()->flash('success', "Pesanan #{$order->order_number} telah dikonfirmasi dan dikirim ke dapur.");
    }
    
    // METHOD BARU untuk menyelesaikan pesanan
    public function completeOrder($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) { return; }

        $order->status = 'selesai';
        $order->save();
        
        $this->loadOrders(); // Muat ulang kedua daftar
        session()->flash('success', "Pesanan #{$order->order_number} telah diselesaikan.");
    }

    public function render()
    {
        return view('livewire.order.kasir-view');
    }
}