<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Blok PHP untuk menentukan sapaan berdasarkan waktu --}}
            @php
                $hour = now()->setTimezone('Asia/Jakarta')->hour;

                if ($hour < 12) {
                    $greeting = 'Selamat Pagi';
                } elseif ($hour < 15) {
                    $greeting = 'Selamat Siang';
                } elseif ($hour < 19) {
                    $greeting = 'Selamat Sore';
                } else {
                    $greeting = 'Selamat Malam';
                }
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Kita gunakan Flexbox untuk menata logo dan teks berdampingan --}}
                <div class="p-8 bg-white border-b border-gray-200 flex items-center space-x-6">
                    
                    {{-- Bagian Logo --}}
                    {{-- Memanggil komponen logo yang sudah kita ubah sebelumnya --}}
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-20 w-auto fill-current text-gray-800" />
                        </a>
                    </div>

                    {{-- Bagian Teks Sambutan --}}
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{-- Menampilkan sapaan dinamis --}}
                            {{ $greeting }}, {{ Auth::user()->name }}!
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Selamat datang kembali di dasbor aplikasi. Siap untuk memulai harimu?
                        </p>
                        
                        {{-- Tombol Aksi Cepat --}}
                        <div class="mt-6">
                            <a href="{{ route('order') }}" 
                               class="inline-block bg-indigo-600 text-white font-bold py-2 px-5 rounded-lg shadow-md hover:bg-indigo-700 transition-all duration-200">
                                Pergi ke Halaman Order
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>