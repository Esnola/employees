<?php

use App\Enums\DepartmentEnum;
use App\Enums\PositionEnum;
use App\Enums\StatusEnum;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

uses(TestCase::class);

test('enum options are ordered by their translated spanish labels', function () {
    App::setLocale('es');

    expect(array_map(
        fn (DepartmentEnum $department): string => $department->value,
        DepartmentEnum::localizedCases()
    ))->toBe([
        'Finance',
        'Engineering',
        'Marketing',
        'Operations',
        'HR',
        'Sales',
    ]);

    expect(array_map(
        fn (PositionEnum $position): string => $position->value,
        PositionEnum::localizedCases()
    ))->toBe([
        'Analyst',
        'Coordinator',
        'Developer',
        'Senior Developer',
        'Designer',
        'Manager',
    ]);

    expect(array_map(
        fn (StatusEnum $status): string => $status->label(),
        StatusEnum::localizedCases()
    ))->toBe([
        'activo',
        'inactivo',
    ]);
});

test('enum options are ordered by their translated english labels', function () {
    App::setLocale('en');

    expect(array_map(
        fn (DepartmentEnum $department): string => $department->value,
        DepartmentEnum::localizedCases()
    ))->toBe([
        'Engineering',
        'Finance',
        'HR',
        'Marketing',
        'Operations',
        'Sales',
    ]);
});
