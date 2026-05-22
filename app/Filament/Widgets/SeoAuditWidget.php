<?php

namespace App\Filament\Widgets;

use App\Services\TrackingService;
use Filament\Widgets\Widget;

class SeoAuditWidget extends Widget
{
    protected string $view = 'filament.widgets.seo-audit';

    protected int | string | array $columnSpan = 'full';

    public function getAuditData(): array
    {
        // This will be populated via the API
        return [];
    }
}
