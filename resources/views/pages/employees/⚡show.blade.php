<?php

  use App\Models\Employee;
  use Livewire\Attributes\Computed;
  use Livewire\Attributes\Title;
  use Livewire\Component;

  new #[Title('Showing Employee')]
  class extends Component {
    public Employee $employee;

  }

?>

<div>
  <flux:badge class="{{ $employee->status->classes() }}">{{ $employee->status->value }}</flux:badge>
  <h1>{{ $employee->full_name }}</h1>
  <p>Email: {{ $employee->email }}</p>
  <flux:badge class="{{ $employee->department->classes() }}">Department: {{ $employee->department->value }}</flux:badge>
  <p>Position: {{ $employee->position }}</p>
  <p>Salary: {{ $employee->formatSalary() }}</p>
  <p>Hire Date: {{ $employee->hire_date }}</p>
  <p>Status: {{ $employee->status->value }}</p>


</div>
