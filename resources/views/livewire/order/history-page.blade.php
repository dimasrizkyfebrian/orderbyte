<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan Anda</h2>

            {{-- Pesan Sukses --}}
            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($orders as $order)
                    {{-- Kartu untuk satu pesanan --}}
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-lg font-bold text-gray-900">Pesanan {{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->isoFormat('dddd, D MMMM Y') }}</p>
                            </div>
                            <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($order->total_price) }}</p>
                        </div>
                        <hr class="my-4">
                        
                        {{-- Daftar item di dalam pesanan --}}
                        <div class="space-y-3">
                            <p class="font-semibold text-gray-700">Item yang dipesan:</p>
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center">
                                    <span>{{ $item->quantity }}x {{ $item->menu->name }}</span>
                                    
                                    {{-- Cek apakah item ini sudah direview untuk order ini --}}
                                    @php
                                        $existingReview = $order->reviews->where('menu_id', $item->menu_id)->first();
                                    @endphp

                                    @if($existingReview)
                                        <span class="text-sm text-yellow-500 font-semibold">Anda memberi: {{ str_repeat('★', $existingReview->rating) }}{{ str_repeat('☆', 5 - $existingReview->rating) }}</span>
                                    @else
                                        <button wire:click="openReviewModal({{ $item->menu_id }}, {{ $order->id }})" class="text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                            Beri Ulasan
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Kamu belum memiliki riwayat pesanan yang selesai.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- MODAL UNTUK MEMBERI ULASAN --}}
    {{-- ====================================================== --}}
    @if($showReviewModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-2">Beri Ulasan untuk</h3>
            <p class="text-lg text-indigo-600 mb-4">{{ $reviewingMenu->name ?? '' }}</p>

            {{-- Komponen Rating Bintang --}}
            <div class="flex items-center space-x-2 mb-4">
                <label class="font-medium">Rating:</label>
                @for ($i = 1; $i <= 5; $i++)
                    <svg wire:click="$set('rating', {{ $i }})" 
                         class="w-8 h-8 cursor-pointer {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" 
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
            </div>
            
            {{-- Komentar --}}
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700">Komentar (opsional):</label>
                <textarea wire:model.lazy="comment" id="comment" rows="4" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            
            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end space-x-3">
                <button wire:click="$set('showReviewModal', false)" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded">
                    Batal
                </button>
                <button wire:click="submitReview" class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                    Kirim Ulasan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>