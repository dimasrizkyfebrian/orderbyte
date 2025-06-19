{{-- Kita asumsikan kamu menggunakan layout standar dari Laravel Breeze --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Judul halaman akan berubah sesuai role --}}
            @can('is-pelanggan')
                Buat Pesanan Baru
            @endcan
            @can('is-kitchen')
                Dapur
            @endcan
            @can('is-kasir')
                Dasbor Kasir
            @endcan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Di sinilah keajaiban terjadi. Laravel akan memeriksa role --}}
                    {{-- pengguna dan hanya menampilkan SATU komponen yang sesuai. --}}

                    @can('is-pelanggan')
                        <livewire:order.customer-view />
                    @endcan

                    @can('is-kitchen')
                        <livewire:order.kitchen-view />
                    @endcan

                    @can('is-kasir')
                        <livewire:order.kasir-view />
                    @endcan

                </div>
            </div>
        </div>
    </div>
</x-app-layout>