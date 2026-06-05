<?php

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('employees per page selector changes how many employees are shown', function () {
    Employee::factory()
        ->count(12)
        ->sequence(fn ($sequence) => [
            'first_name' => sprintf('Employee %02d', $sequence->index + 1),
            'last_name' => 'Pagination',
            'email' => sprintf('employee-%02d@example.com', $sequence->index + 1),
        ])
        ->create();

    Livewire::test('pages::employees.index')
        ->assertSee('Employee 10 Pagination')
        ->assertDontSee('Employee 11 Pagination')
        ->set('perPage', 20)
        ->assertSee('Employee 11 Pagination')
        ->set('perPage', 'all')
        ->assertSee('Employee 12 Pagination');
});
