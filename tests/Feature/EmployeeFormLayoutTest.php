<?php

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('employee notes use a full width html editor', function () {
    $template = file_get_contents(resource_path('views/components/employees/create-edit.blade.php'));
    $editor = file_get_contents(resource_path('views/components/html-editor.blade.php'));

    expect($template)
        ->toContain('<div class="mt-4 w-full">')
        ->toContain('<x-html-editor model="form.notes" :label="__(\'Notes\')" />');

    expect($editor)
        ->toContain('contenteditable="true"')
        ->toContain('html-editor-content')
        ->toContain('value: @entangle($model)')
        ->not->toContain('value: @entangle($model).live')
        ->toContain('x-on:click.stop')
        ->toContain('x-on:mousedown.prevent')
        ->toContain("x-on:click.prevent=\"format('bold')\"");
});

test('employee create edit modal wrapper is reused by list and show pages', function () {
    $indexTemplate = file_get_contents(resource_path('views/pages/employees/⚡index/index.blade.php'));
    $showTemplate = file_get_contents(resource_path('views/pages/employees/⚡show.blade.php'));
    $modalTemplate = file_get_contents(resource_path('views/components/employees/create-edit-modal.blade.php'));

    expect($indexTemplate)
        ->toContain('<x-employees.create-edit-modal')
        ->not->toContain('<flux:modal'."\n".'          flyout');

    expect($showTemplate)
        ->toContain('<x-employees.create-edit-modal')
        ->not->toContain('<flux:modal'."\n".'          flyout');

    expect($modalTemplate)
        ->toContain('<flux:modal')
        ->toContain('<x-employees.create-edit');
});

test('employee notes are loaded when editing', function () {
    $employee = Employee::factory()->create([
        'notes' => 'Prefers remote onboarding notes.',
    ]);

    Livewire::test('pages::employees.index')
        ->call('edit', $employee)
        ->assertSet('form.notes', 'Prefers remote onboarding notes.');
});

test('employee show page uses shared edit form logic', function () {
    $employee = Employee::factory()->create([
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
    ]);

    Livewire::test('pages::employees.show', ['employee' => $employee])
        ->call('edit')
        ->assertSet('form.first_name', 'Ada')
        ->set('form.first_name', 'Grace')
        ->call('update')
        ->assertHasNoErrors()
        ->assertSet('title', __('Employee').': Grace Lovelace')
        ->assertSee(__('Employee updated successfully.'));

    expect($employee->refresh()->first_name)->toBe('Grace');
});

test('employee notes are saved from the form', function () {
    Livewire::test('pages::employees.index')
        ->set('form.first_name', 'Ada')
        ->set('form.last_name', 'Lovelace')
        ->set('form.email', 'ada@example.com')
        ->set('form.phone', '555-123')
        ->set('form.department', 'Engineering')
        ->set('form.position', 'Developer')
        ->set('form.salary', 50000)
        ->set('form.hire_date', '2026-01-15')
        ->set('form.status', 'active')
        ->set('form.notes', '<strong>Needs</strong> a standing desk.')
        ->call('store')
        ->assertHasNoErrors();

    expect(Employee::firstOrFail()->notes)->toBe('<strong>Needs</strong> a standing desk.');
});

test('employee notes html is cleaned before saving', function () {
    Livewire::test('pages::employees.index')
        ->set('form.first_name', 'Ada')
        ->set('form.last_name', 'Lovelace')
        ->set('form.email', 'ada@example.com')
        ->set('form.phone', '555-123')
        ->set('form.department', 'Engineering')
        ->set('form.position', 'Developer')
        ->set('form.salary', 50000)
        ->set('form.hire_date', '2026-01-15')
        ->set('form.status', 'active')
        ->set('form.notes', '<p onclick="alert(1)">Safe</p><script>alert(1)</script><strong class="x">Bold</strong>')
        ->call('store')
        ->assertHasNoErrors();

    expect(Employee::firstOrFail()->notes)->toBe('<p>Safe</p><strong>Bold</strong>');
});

test('employee show notes display ordered and unordered list markers', function () {
    $showTemplate = file_get_contents(resource_path('views/pages/employees/⚡show.blade.php'));
    $css = file_get_contents(resource_path('css/app.css'));

    expect($showTemplate)
        ->toContain('employee-notes-content');

    expect($css)
        ->toContain('.employee-notes-content ul')
        ->toContain('.html-editor-content ul')
        ->toContain('@apply my-2 list-disc space-y-1 pl-6;')
        ->toContain('.employee-notes-content ol')
        ->toContain('.html-editor-content ol')
        ->toContain('@apply my-2 list-decimal space-y-1 pl-6;')
        ->toContain('.html-editor-content strong')
        ->toContain('.html-editor-content u');
});
