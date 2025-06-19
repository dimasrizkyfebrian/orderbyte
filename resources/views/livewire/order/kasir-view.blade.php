<div>
    {{-- Notifikasi Sukses --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <p class="font-bold">Berhasil</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Container Utama dengan Dua Kolom --}}
    <div class="flex flex-col md:flex-row gap-8">

        {{-- KOLOM KIRI: DAFTAR PESANAN --}}
        <div class="w-full md:w-1/3">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Menunggu Pembayaran</h2>
            
            {{-- Kontainer untuk daftar pesanan yang bisa di-scroll --}}
            <div class="bg-white p-4 rounded-lg shadow-md space-y-3 h-[60vh] overflow-y-auto">
                @forelse($unpaidOrders as $order)
                    {{-- Kartu "Tiket" Pesanan --}}
                    <div wire:click="selectOrder({{ $order->id }})" 
                         class="p-4 border rounded-lg cursor-pointer transition-all duration-200 
                                {{ optional($selectedOrder)->id == $order->id ? 'bg-indigo-50 border-indigo-500 shadow' : 'bg-gray-50 hover:bg-gray-100 hover:shadow-sm' }}">
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-lg text-gray-800">Pesanan #{{ $order->order_number }}</span>
                            {{-- Menampilkan sudah berapa lama pesanan dibuat --}}
                            <span class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="text-sm text-gray-600 space-y-1">
                            <p class="flex items-center">
                                {{-- Ikon Meja --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M11.916 2.084A.75.75 0 0112.5 2.75v11.5a.75.75 0 01-1.5 0V7.83l-2.5 1.667a.75.75 0 01-.666 0l-2.5-1.667v6.417a.75.75 0 01-1.5 0V2.75a.75.75 0 01.584-.703L6.5 1.25l2.5 1.667 2.916-.833zM7.25 4.341L6.5 3.87v-.12l.75.5V4.34zm.75 0v-.55l1.5-1v.55l-1.5 1zm1.5 0v-1l1.5-1v1l-1.5 1z"/></svg>
                                {{ $order->table->name }}
                            </p>
                            <p class="flex items-center">
                                {{-- Ikon Pengguna --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" /></svg>
                                {{ $order->user->name ?? 'Walk-in' }}
                            </p>
                        </div>

                        <div class="mt-3 pt-3 border-t">
                            <p class="text-right font-bold text-lg text-indigo-600">Rp {{ number_format($order->total_price) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-16">Tidak ada pesanan.</p>
                @endforelse
            </div>

            <h2 class="text-xl font-bold text-gray-800 mt-8 mb-4">Siap Disajikan / Diselesaikan</h2>
                <div class="bg-white p-4 rounded-lg shadow-md space-y-3 h-[40vh] overflow-y-auto">
                    @forelse($readyOrders as $order)
                        {{-- Kartu untuk pesanan yang siap diselesaikan --}}
                        <div class="p-4 border bg-green-50 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-lg text-gray-800">Pesanan #{{ $order->order_number }}</span>
                                <span class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Meja:</strong> {{ $order->table->name }}</p>
                                <p><strong>Pemesan:</strong> {{ $order->user->name ?? 'Walk-in' }}</p>
                            </div>

                            <button 
                                wire:click="completeOrder({{ $order->id }})"
                                wire:loading.attr="disabled"
                                wire:target="completeOrder({{ $order->id }})"
                                class="w-full mt-3 bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                Selesaikan Pesanan
                            </button>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-16">Tidak ada pesanan yang siap.</p>
                    @endforelse
                </div>
        </div>

        {{-- KOLOM KANAN: DETAIL PESANAN --}}
        <div class="w-full md:w-2/3">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pesanan</h2>

            <div class="bg-white p-6 rounded-lg shadow-md min-h-[60vh]">
                @if($selectedOrder)
                    {{-- Header Detail Pesanan --}}
                    <div class="flex justify-between items-start pb-4 border-b mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Pesanan #{{ $selectedOrder->id }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $selectedOrder->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                            </p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    {{-- Daftar Item yang Dipesan --}}
                    <div class="space-y-2 mb-4">
                        @foreach($selectedOrder->items as $item)
                            <div class="flex justify-between items-center text-gray-700">
                                <span>{{ $item->quantity }}x {{ $item->menu->name }}</span>
                                <span>Rp {{ number_format($item->price * $item->quantity) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Catatan dari Pelanggan --}}
                    @if($selectedOrder->notes)
                        <div class="bg-orange-50 border-l-4 border-orange-400 p-3 rounded-r-lg mt-4">
                            <p class="text-sm font-semibold text-orange-800">Catatan Pelanggan:</p>
                            <p class="text-sm text-orange-700">{{ $selectedOrder->notes }}</p>
                        </div>
                    @endif

                    {{-- Rincian Total Harga --}}
                    <div class="mt-6 pt-4 border-t-2 border-dashed">
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-bold text-gray-800">Grand Total</span>
                            <span class="font-bold text-2xl text-indigo-600">Rp {{ number_format($selectedOrder->total_price) }}</span>
                        </div>
                    </div>

                    {{-- Tombol Aksi Konfirmasi --}}
                    <div class="mt-8">
                        <button 
                            wire:click="confirmPayment({{ $selectedOrder->id }})"
                            wire:loading.attr="disabled"
                            class="w-full flex justify-center items-center bg-green-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:bg-green-700 disabled:opacity-50 transition-all transform hover:scale-105">
                            {{-- Ikon Ceklis --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            Konfirmasi Pembayaran Lunas
                        </button>
                    </div>

                @else
                    {{-- Tampilan saat tidak ada pesanan yang dipilih --}}
                    <div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3.5a1.5 1.5 0 01-3 0V5.5" /></svg>
                        <p class="text-lg font-medium">Pilih Pesanan</p>
                        <p>Klik salah satu pesanan di sebelah kiri untuk melihat detail lengkapnya di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>