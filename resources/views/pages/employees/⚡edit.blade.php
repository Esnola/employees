<?php

  use App\Enums\DepartmentEnum;
  use App\Enums\PositionEnum;
  use App\Enums\StatusEnum;
  use Livewire\Component;
  use Livewire\Attributes\Title;
  use App\Livewire\Forms\EmployeeForm;
  use App\Models\Employee;

  new #[Title('Edit Employee')]
  class extends Component {
    public EmployeeForm $form;

    public $departments = [];
    public $positions = [];
    public $statuses = [];
    public $employee = "";

    public function mount(Employee $employee)
    {
      $this->departments = DepartmentEnum::cases();
      $this->positions = PositionEnum::cases();
      $this->statuses = StatusEnum::cases();
      $this->employee = $employee;
      $this->form->setEmployee($employee);
      $this->title= __('Editing Employee').": ".$employee->full_name;
    }

    public function render()
    {
      return view('pages.employees.⚡edit')
        ->title($this->title);
    }

    public function save()
    {
      $this->form->update();
      session()->flash('message', 'Employee updated successfully.');
      return $this->redirect('/employees');
    }
  };
?>


<div class="px-4 sm:px-6 lg:px-8">
  <div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1 flex gap-2 items-center">
      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:tracking-wide pb-2">
        {{__('Editing Employee') }}: <span class="font-normal underline underline-offset-8">{{ $this->employee->full_name }}</span>
      </h2>
    </div>
  </div>

  <div class="mt-8 max-w-3xl">
    <form wire:submit="save">
      <div class="space-y-6">
        {{-- Personal Information --}}
        <div class="bg-white shadow sm:rounded-lg dark:bg-gray-800">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900/8033 mb-4">
              {{ __('Personal Information')}}
            </h3>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              {{-- First Name --}}
              <x-input-form for="first_name" label="{{ __('First Name')}}" type="text"/>

              {{-- Last Name --}}

              <x-input-form for="last_name" label="{{ __('Last Name')}}" type="text"/>

              {{-- Email --}}
              <x-input-form for="email" label="Email" type="email"/>

              {{-- Phone --}}
            <x-input-form for="phone" label="Phone" type="text"/>
            </div>
          </div>
        </div>

        {{-- Employment Information --}}
        <div class="bg-white shadow sm:rounded-lg dark:bg-gray-800">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900/8033 mb-4">
              {{ __('Employment Information')}}
            </h3>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              {{-- Department --}}
              <x-select-form :label="__('Department')" :for="'department'" :loop="$departments"/>

              {{-- Position --}}
              <x-select-form :label="__('Position')" :for="'position'" :loop="$positions"/>

              {{-- Salary --}}
              <x-input-form for="salary" label="Salary" type="number" />

              {{-- Hire Date --}}
              <x-input-form for="hire_date" label="Hire Date" type="date"/>

              {{-- Status --}}
              <div class="sm:col-span-2">
                <x-select-form :label="__('Status')" :for="'status'" :loop="$statuses"/>
              </div>
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <x-buttons-form :route="route('employees.index')" textbutton="Update Employee"/>
      </div>
    </form>
  </div>
</div>
