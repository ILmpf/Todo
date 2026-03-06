<?php

declare(strict_types=1);

namespace App\Models;

use App\TaskPriority;
use App\TaskStatus;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'due_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    protected $attributes = [
        'status' => TaskStatus::PENDING->value,
        'priority' => TaskPriority::MEDIUM->value,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
