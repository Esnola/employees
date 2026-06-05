<?php

namespace App\Enums;

use App\Enums\Concerns\HasLocalizedCases;

enum DepartmentEnum: string
{
    use HasLocalizedCases;

    case Engineering = 'Engineering';
    case Finance = 'Finance';
    case HR = 'HR';
    case Marketing = 'Marketing';
    case Operations = 'Operations';
    case Sales = 'Sales';

    public function label(): string
    {
        return match ($this) {
            self::Engineering => __('Engineering'),
            self::Finance => __('Finance'),
            self::HR => __('HR'),
            self::Marketing => __('Marketing'),
            self::Operations => __('Operations'),
            self::Sales => __('Sales'),
        };
    }

    public function classes(): string
    {
        return match ($this) {
            self::Engineering => 'bg-blue-300/30! text-blue-500! border border-blue-500! dark:bg-transparent!',
            self::Finance => 'bg-amber-300/30! text-amber-500! border border-amber-500! dark:bg-transparent!',
            self::HR => 'bg-yellow-300/30! text-yellow-500! border border-yellow-500! dark:bg-transparent!',
            self::Marketing => 'bg-purple-300/30! text-purple-500! border border-purple-500! dark:bg-transparent!',
            self::Operations => 'bg-sky-300/30! text-sky-500! border border-sky-500! dark:bg-transparent!',
            self::Sales => 'bg-red-300/30! text-red-500! border border-red-500! dark:bg-transparent!',
        };
    }
}
