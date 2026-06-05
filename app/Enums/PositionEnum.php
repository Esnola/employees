<?php

namespace App\Enums;

use App\Enums\Concerns\HasLocalizedCases;

enum PositionEnum: string
{
    use HasLocalizedCases;

    case Analyst = 'Analyst';
    case Coordinator = 'Coordinator';
    case Designer = 'Designer';
    case Developer = 'Developer';
    case Manager = 'Manager';
    case SeniorDeveloper = 'Senior Developer';

    public function label(): string
    {
        return match ($this) {
            self::Analyst => __('Analyst'),
            self::Coordinator => __('Coordinator'),
            self::Designer => __('Designer'),
            self::Developer => __('Developer'),
            self::Manager => __('Manager'),
            self::SeniorDeveloper => __('Senior Developer'),
        };
    }

    public function classes(): string
    {
        return match ($this) {
            self::Analyst => 'bg-sky-300/30! text-sky-500! border border-sky-500! dark:bg-transparent!',
            self::Coordinator => 'bg-amber-300/30! text-amber-500! border border-amber-500! dark:bg-transparent!',
            self::Designer => 'bg-indigo-300/30! text-indigo-500! border border-indigo-500! dark:bg-transparent!',
            self::Developer => 'bg-purple-300/30! text-purple-500! border border-purple-500! dark:bg-transparent!',
            self::Manager => 'bg-pink-300/30! text-pink-500! border border-pink-500! dark:bg-transparent!',
            self::SeniorDeveloper => 'bg-red-300/30! text-red-500! border border-red-500! dark:bg-transparent!',
        };
    }
}
