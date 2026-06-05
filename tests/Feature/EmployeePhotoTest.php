<?php

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function validEmployeeFormData(string $email = 'ada@example.com'): array
{
    return [
        'form.first_name' => 'Ada',
        'form.last_name' => 'Lovelace',
        'form.email' => $email,
        'form.phone' => '555-123',
        'form.department' => 'Engineering',
        'form.position' => 'Developer',
        'form.salary' => 50000,
        'form.hire_date' => '2026-01-15',
        'form.status' => 'active',
    ];
}

test('an employee can be created with an avatar image', function () {
    Storage::fake('public');

    $component = Livewire::test('pages::employees.index');

    foreach (validEmployeeFormData() as $property => $value) {
        $component->set($property, $value);
    }

    $component
        ->set('form.photo', UploadedFile::fake()->image('avatar.jpg'))
        ->call('store')
        ->assertHasNoErrors();

    $employee = Employee::firstOrFail();

    expect($employee->photo)->toStartWith('avatars/');
    Storage::disk('public')->assertExists($employee->photo);
});

test('employee salary form value is stored in cents', function () {
    $component = Livewire::test('pages::employees.index');

    foreach (validEmployeeFormData() as $property => $value) {
        $component->set($property, $value);
    }

    $component
        ->set('form.salary', 50000.25)
        ->call('store')
        ->assertHasNoErrors();

    expect(Employee::firstOrFail()->salary)->toBe(5000025);
});

test('employee salary is shown in euros when editing', function () {
    $employee = Employee::factory()->create([
        'salary' => 1234567,
    ]);

    Livewire::test('pages::employees.index')
        ->call('edit', $employee)
        ->assertSet('form.salary', 12345.67);
});

test('employee avatar uploads must be images', function () {
    Storage::fake('public');

    $component = Livewire::test('pages::employees.index');

    foreach (validEmployeeFormData() as $property => $value) {
        $component->set($property, $value);
    }

    $component
        ->set('form.photo', UploadedFile::fake()->create('avatar.pdf', 100, 'application/pdf'))
        ->call('store')
        ->assertHasErrors(['form.photo']);

    expect(Employee::query()->count())->toBe(0);
});

test('replacing an employee avatar deletes the old unreferenced image', function () {
    Storage::fake('public');
    Storage::disk('public')->put('avatars/old.png', 'old');

    $employee = Employee::factory()->create([
        'email' => 'grace@example.com',
        'photo' => 'avatars/old.png',
    ]);

    $component = Livewire::test('pages::employees.index')
        ->call('edit', $employee);

    $component
        ->set('form.photo', UploadedFile::fake()->image('new-avatar.png'))
        ->call('update')
        ->assertHasNoErrors();

    $employee->refresh();

    expect($employee->photo)->not->toBe('avatars/old.png');
    Storage::disk('public')->assertMissing('avatars/old.png');
    Storage::disk('public')->assertExists($employee->photo);
});

test('removing an employee avatar clears the database value and deletes the image', function () {
    Storage::fake('public');
    Storage::disk('public')->put('avatars/remove.png', 'remove');

    $employee = Employee::factory()->create([
        'email' => 'katherine@example.com',
        'photo' => 'avatars/remove.png',
    ]);

    Livewire::test('pages::employees.index')
        ->call('edit', $employee)
        ->set('form.removePhoto', true)
        ->call('update')
        ->assertHasNoErrors();

    expect($employee->refresh()->photo)->toBeNull();
    Storage::disk('public')->assertMissing('avatars/remove.png');
});

test('updating an employee flashes a success message when changes are made', function () {
    $employee = Employee::factory()->create([
        'first_name' => 'Ada',
    ]);

    Livewire::test('pages::employees.index')
        ->call('edit', $employee)
        ->set('form.first_name', 'Grace')
        ->call('update')
        ->assertHasNoErrors()
        ->assertSee(__('Employee updated successfully.'));

    expect($employee->refresh()->first_name)->toBe('Grace');
});

test('updating an employee flashes an info message when no changes are made', function () {
    $employee = Employee::factory()->create();

    Livewire::test('pages::employees.index')
        ->call('edit', $employee)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSee(__('No changes were made.'))
        ->assertSee('text-sky-700!', false);
});

test('deleting employees removes avatar images that are no longer registered', function () {
    Storage::fake('public');
    Storage::disk('public')->put('avatars/single.png', 'single');
    Storage::disk('public')->put('avatars/bulk.png', 'bulk');

    $singleEmployee = Employee::factory()->create(['photo' => 'avatars/single.png']);
    $bulkEmployee = Employee::factory()->create(['photo' => 'avatars/bulk.png']);

    Livewire::test('pages::employees.index')
        ->call('confirmDelete', $singleEmployee->id)
        ->call('deleteEmployee');

    Livewire::test('pages::employees.index')
        ->set('selected', [(string) $bulkEmployee->id])
        ->call('bulkDelete');

    Storage::disk('public')->assertMissing('avatars/single.png');
    Storage::disk('public')->assertMissing('avatars/bulk.png');
});
