<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';

    protected static ?int $sort = -1; // Always at the top

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return true; // Show for everyone
    }
}
