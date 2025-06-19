<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Penjualan 7 Hari Terakhir';
    protected static ?string $pollingInterval = '30s'; // Refresh data setiap 30 detik

    protected function getData(): array
    {
        // Mengambil data penjualan, dikelompokkan per hari
        $salesData = Order::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date'); // Menggunakan tanggal sebagai key untuk pencarian mudah

        // Menyiapkan label untuk 7 hari terakhir
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = now()->subDays($i)->format('d M');
        }
        
        // Menyiapkan data untuk setiap label
        $data = [];
        foreach ($labels as $label) {
            $dateString = Carbon::createFromFormat('d M', $label)->format('Y-m-d');
            // Jika ada data penjualan di tanggal tsb, gunakan. Jika tidak, anggap 0.
            $data[] = $salesData->get($dateString)->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
