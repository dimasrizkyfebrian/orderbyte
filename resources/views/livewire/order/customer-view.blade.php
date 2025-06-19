<div>
    {{-- Tampilkan pesan sukses jika ada --}}
    @if (session()->has('success'))
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 20px;">
    
        {{-- KOLOM KIRI: DAFTAR MENU --}}
        <div style="flex: 2;">
            <h2 class="text-2xl font-bold mb-6">Daftar Menu</h2>

            <div>
                {{-- Judul Kategori --}}
                <h3 class="text-xl font-semibold mt-8 mb-4 border-b-2 border-gray-200 pb-2">Kopi</h3>
                
                {{-- Grid Container untuk card menu --}}
                {{-- Ini akan menampilkan 1 kolom di layar kecil, 2 di medium, 3 di large, dst. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- Loop untuk setiap item di kategori ini --}}
                    @foreach($minumanKopi as $item)
                        {{-- Card untuk satu item menu --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            
                            {{-- Gambar Menu --}}
                            {{-- Gambar akan mengisi bagian atas card --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            
                            {{-- Konten Card (Nama, Deskripsi, Harga, Tombol) --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Nama Menu --}}
                                <h4 class="font-bold text-lg">{{ $item->name }}</h4>

                                {{-- Rating Menu --}}
                                <div class="flex items-center mt-2">
                                    @if($item->reviews_count > 0)
                                        {{-- Tampilkan bintang jika sudah ada review --}}
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                {{-- Logika untuk bintang terisi atau kosong --}}
                                                <svg class="w-4 h-4 {{ $i <= round($item->reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        {{-- Tampilkan jumlah ulasan --}}
                                        <span class="text-xs text-gray-500 ml-2">({{ $item->reviews_count }} ulasan)</span>
                                    @else
                                        {{-- Tampilkan ini jika belum ada review --}}
                                        <span class="text-xs text-gray-500">Belum ada ulasan</span>
                                    @endif
                                </div>
                                
                                {{-- Deskripsi Menu --}}
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $item->description }}</p>
                                
                                {{-- Bagian Aksi (Harga & Tombol) diletakkan di bawah --}}
                                <div class="mt-4 flex justify-between items-center">
                                    {{-- Harga --}}
                                    <span class="font-semibold text-gray-800 text-lg">Rp {{ number_format($item->price) }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button wire:click="addToCart({{ $item->id }})" 
                                            class="bg-indigo-600 text-white rounded-full p-2 shadow-lg transform transition-all duration-200 hover:bg-indigo-700 hover:scale-110" 
                                            aria-label="Tambah {{ $item->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <div>
                {{-- Judul Kategori --}}
                <h3 class="text-xl font-semibold mt-8 mb-4 border-b-2 border-gray-200 pb-2">Non-Kopi</h3>
                
                {{-- Grid Container untuk card menu --}}
                {{-- Ini akan menampilkan 1 kolom di layar kecil, 2 di medium, 3 di large, dst. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- Loop untuk setiap item di kategori ini --}}
                    @foreach($minumanNonKopi as $item)
                        {{-- Card untuk satu item menu --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            
                            {{-- Gambar Menu --}}
                            {{-- Gambar akan mengisi bagian atas card --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            
                            {{-- Konten Card (Nama, Deskripsi, Harga, Tombol) --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Nama Menu --}}
                                <h4 class="font-bold text-lg">{{ $item->name }}</h4>
                                
                                {{-- Deskripsi Menu --}}
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $item->description }}</p>
                                
                                {{-- Bagian Aksi (Harga & Tombol) diletakkan di bawah --}}
                                <div class="mt-4 flex justify-between items-center">
                                    {{-- Harga --}}
                                    <span class="font-semibold text-gray-800 text-lg">Rp {{ number_format($item->price) }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button wire:click="addToCart({{ $item->id }})" 
                                            class="bg-indigo-600 text-white rounded-full p-2 shadow-lg transform transition-all duration-200 hover:bg-indigo-700 hover:scale-110" 
                                            aria-label="Tambah {{ $item->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <div>
                {{-- Judul Kategori --}}
                <h3 class="text-xl font-semibold mt-8 mb-4 border-b-2 border-gray-200 pb-2">Makanan Ringan</h3>
                
                {{-- Grid Container untuk card menu --}}
                {{-- Ini akan menampilkan 1 kolom di layar kecil, 2 di medium, 3 di large, dst. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- Loop untuk setiap item di kategori ini --}}
                    @foreach($makananRingan as $item)
                        {{-- Card untuk satu item menu --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            
                            {{-- Gambar Menu --}}
                            {{-- Gambar akan mengisi bagian atas card --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            
                            {{-- Konten Card (Nama, Deskripsi, Harga, Tombol) --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Nama Menu --}}
                                <h4 class="font-bold text-lg">{{ $item->name }}</h4>
                                
                                {{-- Deskripsi Menu --}}
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $item->description }}</p>
                                
                                {{-- Bagian Aksi (Harga & Tombol) diletakkan di bawah --}}
                                <div class="mt-4 flex justify-between items-center">
                                    {{-- Harga --}}
                                    <span class="font-semibold text-gray-800 text-lg">Rp {{ number_format($item->price) }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button wire:click="addToCart({{ $item->id }})" 
                                            class="bg-indigo-600 text-white rounded-full p-2 shadow-lg transform transition-all duration-200 hover:bg-indigo-700 hover:scale-110" 
                                            aria-label="Tambah {{ $item->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <div>
                {{-- Judul Kategori --}}
                <h3 class="text-xl font-semibold mt-8 mb-4 border-b-2 border-gray-200 pb-2">Makanan Berat</h3>
                
                {{-- Grid Container untuk card menu --}}
                {{-- Ini akan menampilkan 1 kolom di layar kecil, 2 di medium, 3 di large, dst. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- Loop untuk setiap item di kategori ini --}}
                    @foreach($makananBerat as $item)
                        {{-- Card untuk satu item menu --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            
                            {{-- Gambar Menu --}}
                            {{-- Gambar akan mengisi bagian atas card --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            
                            {{-- Konten Card (Nama, Deskripsi, Harga, Tombol) --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Nama Menu --}}
                                <h4 class="font-bold text-lg">{{ $item->name }}</h4>
                                
                                {{-- Deskripsi Menu --}}
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $item->description }}</p>
                                
                                {{-- Bagian Aksi (Harga & Tombol) diletakkan di bawah --}}
                                <div class="mt-4 flex justify-between items-center">
                                    {{-- Harga --}}
                                    <span class="font-semibold text-gray-800 text-lg">Rp {{ number_format($item->price) }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button wire:click="addToCart({{ $item->id }})" 
                                            class="bg-indigo-600 text-white rounded-full p-2 shadow-lg transform transition-all duration-200 hover:bg-indigo-700 hover:scale-110" 
                                            aria-label="Tambah {{ $item->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <div>
                {{-- Judul Kategori --}}
                <h3 class="text-xl font-semibold mt-8 mb-4 border-b-2 border-gray-200 pb-2">Makanan Penutup</h3>
                
                {{-- Grid Container untuk card menu --}}
                {{-- Ini akan menampilkan 1 kolom di layar kecil, 2 di medium, 3 di large, dst. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- Loop untuk setiap item di kategori ini --}}
                    @foreach($makananPenutup as $item)
                        {{-- Card untuk satu item menu --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            
                            {{-- Gambar Menu --}}
                            {{-- Gambar akan mengisi bagian atas card --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            
                            {{-- Konten Card (Nama, Deskripsi, Harga, Tombol) --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Nama Menu --}}
                                <h4 class="font-bold text-lg">{{ $item->name }}</h4>
                                
                                {{-- Deskripsi Menu --}}
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $item->description }}</p>
                                
                                {{-- Bagian Aksi (Harga & Tombol) diletakkan di bawah --}}
                                <div class="mt-4 flex justify-between items-center">
                                    {{-- Harga --}}
                                    <span class="font-semibold text-gray-800 text-lg">Rp {{ number_format($item->price) }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button wire:click="addToCart({{ $item->id }})" 
                                            class="bg-indigo-600 text-white rounded-full p-2 shadow-lg transform transition-all duration-200 hover:bg-indigo-700 hover:scale-110" 
                                            aria-label="Tambah {{ $item->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <div>
                {{-- Judul Kategori --}}
                <h3 class="text-xl font-semibold mt-8 mb-4 border-b-2 border-gray-200 pb-2">Menu Spesial</h3>
                
                {{-- Grid Container untuk card menu --}}
                {{-- Ini akan menampilkan 1 kolom di layar kecil, 2 di medium, 3 di large, dst. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- Loop untuk setiap item di kategori ini --}}
                    @foreach($menuSpesial as $item)
                        {{-- Card untuk satu item menu --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            
                            {{-- Gambar Menu --}}
                            {{-- Gambar akan mengisi bagian atas card --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            
                            {{-- Konten Card (Nama, Deskripsi, Harga, Tombol) --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Nama Menu --}}
                                <h4 class="font-bold text-lg">{{ $item->name }}</h4>
                                
                                {{-- Deskripsi Menu --}}
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $item->description }}</p>
                                
                                {{-- Bagian Aksi (Harga & Tombol) diletakkan di bawah --}}
                                <div class="mt-4 flex justify-between items-center">
                                    {{-- Harga --}}
                                    <span class="font-semibold text-gray-800 text-lg">Rp {{ number_format($item->price) }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button wire:click="addToCart({{ $item->id }})" 
                                            class="bg-indigo-600 text-white rounded-full p-2 shadow-lg transform transition-all duration-200 hover:bg-indigo-700 hover:scale-110" 
                                            aria-label="Tambah {{ $item->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: KERANJANG & CHECKOUT --}}
        <div class="flex-1 bg-gray-50 p-6 rounded-lg shadow-inner">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Keranjang Anda</h2>

            @if(empty($cart))
                <div class="text-center text-gray-500 mt-8">
                    <p>Keranjang masih kosong.</p>
                    <p class="text-sm">Silakan pilih menu dari daftar di sebelah kiri.</p>
                </div>
            @else
                {{-- Daftar Item di Keranjang --}}
                <div class="space-y-4">
                    @foreach($cart as $id => $item)
                        {{-- Satu Item Keranjang --}}
                        <div class="flex justify-between items-center">
                            {{-- Info Item --}}
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-600">x {{ $item['quantity'] }}</p>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                {{-- Harga per Item --}}
                                <p class="text-gray-800">Rp {{ number_format($item['price'] * $item['quantity']) }}</p>
                                
                                {{-- Tombol Hapus (Ikon Sampah) --}}
                                <button wire:click="removeFromCart({{ $id }})" class="p-1.5 rounded-full text-red-500 hover:bg-red-100 transition-colors" aria-label="Hapus {{ $item['name'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-1.157.06-2.185.213-3.14.443a.75.75 0 0 0-.523.69c-.046.205-.083.415-.11.625A.75.75 0 0 0 3 6.393V15.25A2.75 2.75 0 0 0 5.75 18h8.5A2.75 2.75 0 0 0 17 15.25V6.393a.75.75 0 0 0 .123-.69c-.027-.21-.064-.42-.11-.625a.75.75 0 0 0-.523-.69c-.955-.23-1.983-.384-3.14-.443v-.443A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.414 0 .75.336.75.75V15a.75.75 0 0 1-1.5 0V4.75A.75.75 0 0 1 10 4Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Total Harga --}}
                <div class="mt-6 pt-4 border-t-2 border-dashed">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-800">Total</span>
                        <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPrice) }}</span>
                    </div>
                </div>

                {{-- Form Meja & Catatan --}}
                <div class="mt-6 space-y-4">
                    {{-- Pilihan Meja --}}
                    <div>
                        <label for="table" class="block text-sm font-medium text-gray-700 mb-1">Pilih Meja</label>
                        <select wire:model="selectedTable" id="table" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Meja --</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedTable') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea wire:model.lazy="note" id="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: jangan pakai bawang..."></textarea>
                    </div>
                </div>
                
                {{-- Tombol Checkout (Paling Penting) --}}
                <div class="mt-8">
                    <button 
                        wire:click="checkout" 
                        wire:loading.attr="disabled"
                        class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform hover:scale-105">
                        <span wire:loading.remove wire:target="checkout">Lanjutkan ke Pembayaran</span>
                        <span wire:loading wire:target="checkout">Memproses...</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>