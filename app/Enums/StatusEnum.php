<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => __('Active'),
            self::Inactive => __('Inactive'),
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
