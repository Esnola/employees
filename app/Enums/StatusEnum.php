<?php

namespace App\Enums;

use App\Enums\Concerns\HasLocalizedCases;

enum StatusEnum: string
{
    use HasLocalizedCases;

    case Active = 'active';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => __('active'),
            self::Inactive => __('inactive'),
        };
    }

    public function classes(): string
    {
        return match ($this) {
            self::Active => 'text-green-500! border border-green-500!',
            self::Inactive => 'text-red-500/60! border border-red-500/60!',
        };
    }
}
