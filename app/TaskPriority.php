<?php

declare(strict_types=1);

namespace App;

enum TaskPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Baixa',
            self::MEDIUM => 'Média',
            self::HIGH => 'Alta'
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::LOW => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            self::MEDIUM => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            self::HIGH => 'bg-red-50 text-red-700 ring-red-600/20',
        };
    }

    public function dotClass(): string
    {
        return match ($this) {
            self::LOW => 'bg-emerald-500',
            self::MEDIUM => 'bg-amber-500',
            self::HIGH => 'bg-red-500',
        };
    }
}
