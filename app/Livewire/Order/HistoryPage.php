<?php

namespace App\Livewire\Order;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')] // Menggunakan layout app.blade.php
class HistoryPage extends Component
{
    public $orders;

    // Properti untuk modal review
    public $showReviewModal = false;
    public $reviewingMenu;
    public $reviewingOrder;
    public $rating = 5;
    public $comment = '';

    public function mount()
    {
        // Ambil semua order milik user yang login dengan status 'selesai'
        // 'with()' mengambil relasi untuk mencegah N+1 query problem
        $this->orders = Order::where('user_id', Auth::id())
                            ->where('status', 'selesai') 
                            ->with('items.menu', 'reviews')
                            ->latest()
                            ->get();
    }

    // Method untuk membuka modal review
    public function openReviewModal($menuId, $orderId)
    {
        $this->reviewingMenu = Menu::find($menuId);
        $this->reviewingOrder = Order::find($orderId);
        $this->rating = 5; // Reset rating ke default
        $this->comment = ''; // Reset komentar
        $this->showReviewModal = true;
    }

    // Method untuk menyimpan ulasan ke database
    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'menu_id' => $this->reviewingMenu->id,
            'order_id' => $this->reviewingOrder->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->showReviewModal = false;
        session()->flash('message', 'Terima kasih atas ulasanmu!');
        
        // Refresh data order untuk memperbarui tampilan
        $this->mount();
    }

    public function render()
    {
        return view('livewire.order.history-page');
    }
}