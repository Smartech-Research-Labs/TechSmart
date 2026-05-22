<?php

namespace App\Filament\Pages;

use App\Models\SeoData;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    public function getHeading(): string
    {
        return 'SEO Management Dashboard';
    }

    public function getSubHeading(): ?string
    {
        $totalPages = SeoData::count();
        $indexedPages = SeoData::where('index', true)->count();
        
        return "Total Pages: {$totalPages} | Indexed: {$indexedPages}";
    }
}
