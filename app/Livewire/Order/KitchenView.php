<?php
// app/Livewire/Order/KitchenView.php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class KitchenView extends Component
{
    public $orders;

    /**
     * Ini adalah "telinga" komponen.
     * Dia akan mendengarkan event yang disiarkan oleh Laravel Echo.
     * Saat 'OrderPaidEvent' terdengar, panggil method 'loadOrders'.
     */
    protected $listeners = ['echo:orders,OrderPaidEvent' => 'loadOrders'];

    /**
     * Method mount berjalan saat komponen di-load pertama kali.
     */
    public function mount()
    {
        $this->loadOrders();
    }

    /**
     * Method untuk mengambil data pesanan dari database.
     * Dibuat terpisah agar bisa dipanggil ulang.
     */
    public function loadOrders()
    {
        // Ambil order dengan status 'diproses'
        // 'with()' adalah Eager Loading, sangat penting untuk performa!
        // Dia akan mengambil semua relasi (items, menu, table) dalam satu query besar.
        $this->orders = Order::where('status', 'diproses')
                            ->with('items.menu', 'table', 'user')
                            ->latest() // Tampilkan yang terbaru di atas
                            ->get();
    }

    /**
     * Method untuk menandai pesanan selesai dan mengurangi stok.
     */
    public function markAsReady($orderId)
    {
        // DB::transaction memastikan semua query berhasil,
        // atau semua akan dibatalkan jika ada satu saja yang gagal.
        // Ini mencegah status order berubah jika pengurangan stok gagal.
        DB::transaction(function () use ($orderId) {
            $order = Order::with('items.menu')->find($orderId);

            if (!$order) {
                return; // Order tidak ditemukan
            }

            // 1. Loop setiap item dalam pesanan untuk mengurangi stok
            foreach ($order->items as $item) {
                // 'decrement' adalah cara aman untuk mengurangi nilai
                Menu::find($item->menu_id)->decrement('stock_quantity', $item->quantity);
            }

            // 2. Ubah status order menjadi 'siap_disajikan'
            $order->status = 'siap_disajikan';
            $order->save();
        });

        // 3. Muat ulang daftar pesanan di layar
        $this->loadOrders();
        
        // Di sini kita bisa menyiarkan event baru, misal untuk notifikasi ke pelanggan
        // event(new OrderIsReady($orderId));
    }

    public function render()
    {
        return view('livewire.order.kitchen-view');
    }
}