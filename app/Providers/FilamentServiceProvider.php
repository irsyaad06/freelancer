<?php

namespace App\Providers;

use App\Filament\Widgets\DashboardStatsWidget;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerWidgets([
                DashboardStatsWidget::class,
            ]);
        });
    }
}
