<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total pendapatan hari ini
        $totalRevenueToday = Order::whereDate('created_at', today())->sum('total_price');

        // Menghitung total pendapatan kemarin untuk perbandingan
        $totalRevenueYesterday = Order::whereDate('created_at', today()->subDay())->sum('total_price');
        
        // Menghitung persentase perubahan dari kemarin
        $revenueChange = $totalRevenueYesterday > 0 
            ? (($totalRevenueToday - $totalRevenueYesterday) / $totalRevenueYesterday) * 100 
            : 100;

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($totalRevenueToday))
                ->description(sprintf('%.2f%% dari kemarin', $revenueChange))
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger'),

            Stat::make('Pesanan Baru Hari Ini', Order::whereDate('created_at', today())->count())
                ->description('Total pesanan yang masuk hari ini')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Total Pelanggan', User::where('role', 'pelanggan')->count())
                ->description('Jumlah pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}
