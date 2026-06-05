<?php

namespace App\Livewire\Employees\Concerns;

use App\Enums\DepartmentEnum;
use App\Enums\PositionEnum;
use App\Enums\StatusEnum;
use App\Livewire\Forms\EmployeeForm;
use App\Models\Employee;
use Flux\Flux;
use Livewire\WithFileUploads;

trait ManagesEmployeeForm
{
    use WithFileUploads;

    public EmployeeForm $form;

    public ?Employee $editingEmployee = null;

    public array $departments = [];

    public array $positions = [];

    public array $statuses = [];

    protected function mountEmployeeForm(): void
    {
        $this->departments = DepartmentEnum::localizedCases();
        $this->positions = PositionEnum::localizedCases();
        $this->statuses = StatusEnum::localizedCases();
    }

    public function edit(?Employee $employee = null): void
    {
        $employee ??= property_exists($this, 'employee') && $this->employee instanceof Employee
            ? $this->employee
            : null;

        if (! $employee) {
            return;
        }

        $this->editingEmployee = $employee;
        $this->form->setEmployee($employee);
        Flux::modal('edit-employee')->show();
    }

    public function create(): void
    {
        $this->editingEmployee = null;
        $this->form->reset();

        Flux::modal('create-employee')->show();
    }

    public function store(): void
    {
        $this->form->store();
        $this->dispatch('close-flux-modal-with-transition', name: 'create-employee');
        session()->flash('message', __('Employee created successfully.'));
    }

    public function update(): void
    {
        $hasChanges = $this->form->update();

        $this->afterEmployeeUpdate($hasChanges);
        $this->dispatch('close-flux-modal-with-transition', name: 'edit-employee');
        $this->flashEmployeeUpdateMessage($hasChanges);
    }

    protected function afterEmployeeUpdate(bool $hasChanges): void
    {
        //
    }

    private function flashEmployeeUpdateMessage(bool $hasChanges): void
    {
        if ($hasChanges) {
            session()->flash('message', __('Employee updated successfully.'));

            return;
        }

        session()->flash('message', __('No changes were made.'));
        session()->flash('message_type', 'info');
    }
}
