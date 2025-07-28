<?php

namespace App\Filament\Widgets;

use App\Models\Freelancer;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Freelancer', Freelancer::count())
                ->description('Total Freelancer Terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Jumlah Pembeli Pending', Order::distinct()->where('status', 'pending')->count('id'))
                ->description('Total Pesanan Pending')
                ->icon('heroicon-o-shopping-cart')
                ->color('warning'),

            Stat::make('Jumlah Pesanan Selesai', Order::distinct()->where('status', 'completed')->count('id'))
                ->description('Total Pesanan Selesai')
                ->icon('heroicon-o-check-badge')
                ->color('success'),
        ];
    }
}
