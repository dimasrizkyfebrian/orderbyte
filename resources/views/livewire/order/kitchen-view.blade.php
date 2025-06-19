<div wire:poll.5s class="bg-gray-100 p-4 sm:p-6 lg:p-8 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Papan Pesanan Dapur</h1>
    
    @if($orders->isEmpty())
        {{-- Tampilan saat tidak ada pesanan aktif --}}
        <div class="flex flex-col items-center justify-center bg-white rounded-lg shadow-md p-16 text-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mb-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-xl font-medium">Semua pesanan sudah selesai!</p>
            <p>Dapur bersih, saatnya bersiap untuk pesanan berikutnya.</p>
        </div>
    @else
        {{-- Grid Container untuk semua tiket pesanan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            @foreach($orders as $order)
                {{-- ====================================================== --}}
                {{-- SATU TIKET PESANAN --}}
                {{-- ====================================================== --}}
                {{-- Latar belakang tiket akan berubah menjadi merah jika pesanan sudah menunggu lebih dari 10 menit --}}
                <div class="bg-white rounded-lg shadow-xl flex flex-col transition-all duration-300 {{ $order->created_at->diffInMinutes() > 10 ? 'border-4 border-red-500' : 'border-4 border-transparent' }}">
                    
                    {{-- Header Tiket (Info & Timer) --}}
                    <div class="p-4 border-b-2 border-dashed {{ $order->created_at->diffInMinutes() > 10 ? 'bg-red-50' : 'bg-gray-50' }}">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xl font-extrabold text-gray-800">Pesanan #{{ $order->id }}</p>
                                <p class="text-sm font-semibold text-gray-600">Meja: {{ $order->table->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-red-600">{{ $order->created_at->diffForHumans() }}</p>
                                <p class="text-xs text-gray-500">Masuk</p>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Item Masakan --}}
                    <div class="p-4 space-y-3 flex-grow overflow-y-auto">
                        @foreach($order->items as $item)
                            <div class="flex items-start space-x-3">
                                {{-- Kuantitas --}}
                                <div class="bg-gray-800 text-white font-bold text-xl rounded-md w-10 h-10 flex items-center justify-center flex-shrink-0">
                                    {{ $item->quantity }}x
                                </div>
                                {{-- Nama Item --}}
                                <div class="font-semibold text-lg text-gray-800">
                                    {{ $item->menu->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Kotak Catatan (PENTING!) --}}
                    @if($order->notes)
                        <div class="m-4 p-3 bg-yellow-100 border-l-4 border-yellow-500 rounded-r-lg">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.636-1.213 2.45-1.213 3.086 0l4.331 8.24a.75.75 0 01-.649 1.161H4.575a.75.75 0 01-.649-1.161l4.331-8.24zM9.25 6.5a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5zM10 12a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                                <p class="font-bold text-yellow-800">CATATAN PENTING</p>
                            </div>
                            <p class="text-yellow-700 mt-1 pl-8">{{ $order->notes }}</p>
                        </div>
                    @endif
                    
                    {{-- Tombol Aksi Selesai --}}
                    <div class="p-4 mt-auto">
                        <button 
                            wire:click="markAsReady({{ $order->id }})"
                            wire:loading.attr="disabled"
                            class="w-full flex justify-center items-center bg-green-500 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:bg-green-600 disabled:opacity-50 transition-all transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Selesai & Siap Disajikan
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>