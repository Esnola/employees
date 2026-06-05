<?php

namespace App\Livewire\Forms;

use App\Enums\DepartmentEnum;
use App\Enums\PositionEnum;
use App\Enums\StatusEnum;
use App\Models\Employee;
use BackedEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?Employee $employee = null;

    public $first_name = '';

    public $last_name = '';

    public $email = '';

    public $photo = null;

    public bool $removePhoto = false;

    public $phone = '';

    public $salary = '';

    public $hire_date = '';

    public $status = 'active';

    public $department = '';

    public $position = '';

    public $notes = '';

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($this->employee),
            ],
            'phone' => ['nullable', 'string'],
            'photo' => ['nullable', File::image()->max('2mb')],
            'removePhoto' => ['boolean'],
            'salary' => ['required', 'numeric', 'min:0'],
            'hire_date' => ['required', 'date'],
            'status' => ['required', Rule::enum(StatusEnum::class)],
            'department' => ['required', Rule::enum(DepartmentEnum::class)],
            'position' => ['required', Rule::enum(PositionEnum::class)],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function setEmployee(Employee $employee): void
    {
        $this->employee = $employee;

        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->department = $this->enumValue($employee->department);
        $this->position = $this->enumValue($employee->position);
        $this->salary = $employee->salary / 100;
        $this->hire_date = $employee->hire_date->format('Y-m-d');
        $this->status = $this->enumValue($employee->status);
        $this->notes = $employee->notes;
        $this->photo = null;
        $this->removePhoto = false;
    }

    public function store(): void
    {
        $this->validate();

        $data = $this->employeeData();

        if ($this->photo) {
            $data['photo'] = $this->photo->store('avatars', 'public');
        }

        Employee::create($data);

        $this->reset();
    }

    public function update(): bool
    {
        $this->validate();

        $previousPhoto = $this->employee->photo;
        $data = $this->employeeData();

        if ($this->photo) {
            $data['photo'] = $this->photo->store('avatars', 'public');
        } elseif ($this->removePhoto) {
            $data['photo'] = null;
        }

        $hasChanges = $this->hasChanges($data);

        if ($hasChanges) {
            $this->employee->update($data);
        }

        if (array_key_exists('photo', $data) && $previousPhoto !== $data['photo']) {
            Employee::deletePhotoFileIfUnreferenced($previousPhoto);
        }

        $this->photo = null;
        $this->removePhoto = false;

        return $hasChanges;
    }

    private function employeeData(): array
    {
        return [
            ...$this->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'hire_date',
            ]),
            'notes' => $this->cleanNotesHtml($this->notes),
            'salary' => $this->salaryInCents(),
            'department' => $this->enumValue($this->department),
            'position' => $this->enumValue($this->position),
            'status' => $this->enumValue($this->status),
        ];
    }

    private function salaryInCents(): int
    {
        return (int) round((float) $this->salary * 100);
    }

    private function cleanNotesHtml(?string $notes): ?string
    {
        $notes = trim((string) $notes);

        if ($notes === '') {
            return null;
        }

        $notes = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $notes);
        $notes = strip_tags($notes, '<p><br><strong><b><em><i><u><ul><ol><li>');

        return preg_replace('/<([a-z][a-z0-9]*)(?:\s[^>]*)?>/i', '<$1>', $notes);
    }

    private function enumValue(mixed $value): mixed
    {
        return $value instanceof BackedEnum ? $value->value : $value;
    }

    private function hasChanges(array $data): bool
    {
        foreach ($data as $field => $value) {
            $currentValue = match ($field) {
                'hire_date' => $this->employee->hire_date->format('Y-m-d'),
                'department', 'position', 'status' => $this->enumValue($this->employee->{$field}),
                default => $this->employee->{$field},
            };

            if ($currentValue != $value) {
                return true;
            }
        }

        return false;
    }
}
