<?php

namespace App\Filament\Admin\Navigation;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroup: string implements HasLabel
{
    case Content = 'content';
    case System = 'system';
    
    public function getLabel(): string
    {
        return match ($this) {
            self::Content => 'Content',
            self::System => 'System',
        };
    }
}
