<?php
namespace App\Livewire\Order;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Order;

class CustomerView extends Component
{
    // Properti untuk menampung data dari database
    public $minumanKopi = [];
    public $minumanNonKopi = [];
    public $makananRingan = [];
    public $makananBerat = [];
    public $makananPenutup = [];
    public $menuSpesial = [];
    public $tables = [];

    // Properti untuk menampung data pesanan
    public $cart = [];
    public $selectedTable;
    public $note = '';
    public $totalPrice = 0;

    /**
     * Method ini berjalan saat komponen pertama kali di-load.
     * Kita gunakan untuk mengambil data awal dari database.
     */
    public function mount()
    {
        // Ambil menu yang relasi kategorinya punya nama 'Menu'
        $this->minumanKopi = Menu::whereHas('category', function ($query) {
            $query->where('type', 'Minuman Kopi');
        })
        ->withCount('reviews') // <-- Tambahkan ini untuk menghitung jumlah review
        ->withAvg('reviews', 'rating') // <-- Tambahkan ini untuk menghitung rata-rata rating
        ->get();

        // Ambil menu yang relasi kategorinya punya nama 'Menu'
        $this->minumanNonKopi = Menu::whereHas('category', function ($query) {
            $query->where('type', 'Minuman Non-Kopi');
        })
        ->withCount('reviews') // <-- Tambahkan ini untuk menghitung jumlah review
        ->withAvg('reviews', 'rating') // <-- Tambahkan ini untuk menghitung rata-rata rating
        ->get();

        // Ambil menu yang relasi kategorinya punya nama 'Menu'
        $this->makananRingan = Menu::whereHas('category', function ($query) {
            $query->where('type', 'Makanan Ringan');
        })
        ->withCount('reviews') // <-- Tambahkan ini untuk menghitung jumlah review
        ->withAvg('reviews', 'rating') // <-- Tambahkan ini untuk menghitung rata-rata rating
        ->get();
        
        // Ambil menu yang relasi kategorinya punya nama 'Menu'
        $this->makananBerat = Menu::whereHas('category', function ($query) {
            $query->where('type', 'Makanan Berat');
        })
        ->withCount('reviews') // <-- Tambahkan ini untuk menghitung jumlah review
        ->withAvg('reviews', 'rating') // <-- Tambahkan ini untuk menghitung rata-rata rating
        ->get();

        // Ambil menu yang relasi kategorinya punya nama 'Menu'
        $this->makananPenutup = Menu::whereHas('category', function ($query) {
            $query->where('type', 'Makanan Penutup');
        })
        ->withCount('reviews') // <-- Tambahkan ini untuk menghitung jumlah review
        ->withAvg('reviews', 'rating') // <-- Tambahkan ini untuk menghitung rata-rata rating
        ->get();

        // Ambil menu yang relasi kategorinya punya nama 'Menu'
        $this->menuSpesial = Menu::whereHas('category', function ($query) {
            $query->where('type', 'Menu Spesial');
        })
        ->withCount('reviews') // <-- Tambahkan ini untuk menghitung jumlah review
        ->withAvg('reviews', 'rating') // <-- Tambahkan ini untuk menghitung rata-rata rating
        ->get();

        // Bagian ini tetap sama
        $this->tables = Table::where('is_available', true)->get();
    }

    /**
     * Menambahkan item ke keranjang.
     */
    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu) {
            return; // Jika menu tidak ditemukan, hentikan
        }

        // Cek jika menu sudah ada di keranjang
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity']++;
        } else {
            // Jika belum ada, tambahkan baru
            $this->cart[$menuId] = [
                'menu_id'  => $menu->id,
                'name'     => $menu->name,
                'price'    => $menu->price,
                'quantity' => 1,
            ];
        }
        $this->calculateTotalPrice();
    }
    
    /**
     * Menghapus item dari keranjang
     */
    public function removeFromCart($menuId)
    {
        unset($this->cart[$menuId]);
        $this->calculateTotalPrice();
    }
    
    /**
     * Menghitung ulang total harga
     */
    public function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        foreach($this->cart as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
    }

    /**
     * Proses checkout untuk menyimpan pesanan.
     */
    public function checkout()
    {
        // Validasi sederhana
        $this->validate([
            'selectedTable' => 'required',
            'cart' => 'required',
        ]);
        
        // 1. Simpan ke tabel 'orders'
        $order = Order::create([
            'user_id' => Auth::id(),
            'table_id' => $this->selectedTable,
            'total_price' => $this->totalPrice,
            'status' => 'menunggu_pembayaran', // Status awal
            'notes' => $this->note,
        ]);

        // 2. Simpan setiap item di keranjang ke tabel 'order_items'
        foreach ($this->cart as $item) {
            $order->items()->create([
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // 3. Reset keranjang dan tampilkan pesan sukses
        $this->cart = [];
        $this->note = '';
        $this->selectedTable = null;
        $this->totalPrice = 0;
        
        session()->flash('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran di kasir.');

        // Nanti di sini kita bisa redirect atau menampilkan status order
    }


    /**
     * Method wajib untuk me-render tampilan.
     */
    public function render()
    {
        return view('livewire.order.customer-view');
    }
}