<?php

declare(strict_types=1);

namespace App;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::IN_PROGRESS => 'Em progresso',
            self::COMPLETED => 'Concluída',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-beige-200 text-warm-700 ring-warm-500/20',
            self::IN_PROGRESS => 'bg-blue-50 text-blue-700 ring-blue-600/20',
            self::COMPLETED => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        };
    }
}
