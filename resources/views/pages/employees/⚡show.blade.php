<?php
  
  use App\Livewire\Employees\Concerns\ManagesEmployeeForm;
  use App\Models\Employee;
  use Livewire\Component;
  
  new class extends Component {
    use ManagesEmployeeForm;

    public Employee $employee;
    public string $title = "";


    public function mount(): void
    {
      $this->mountEmployeeForm();
      $this->title = __('Employee') . ": " . $this->employee->full_name;
    }

    protected function afterEmployeeUpdate(bool $hasChanges): void
    {
      $this->employee->refresh();
      $this->editingEmployee = $this->employee;
      $this->title = __('Employee') . ": " . $this->employee->full_name;
    }

    public function render(): mixed
    {
      return view('pages.employees.⚡show')
        ->title($this->title);
    }
  }

?>

<div class="max-w-5xl mx-auto p-6">
    <x-flash-message/>
  <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg dark:border-slate-800 dark:bg-slate-950">
    <div class="bg-linear-to-r from-sky-700 to-sky-800 sm:px-6  py-8 text-slate-100/70">
      <div class="flex items-start justify-between gap-12  w-full">
        <a href="{{route('employees.index')}}"
           class="text-slate-100/70 hover:text-slate-100 text-sm flex gap-2 items-center min-w-fit">
          <flux:icon.bars-arrow-up class="w-6 h-6 -rotate-90 group-hover:text-white"/>
          {{__('Employees List')}}
        </a>
        <div class="flex items-center w-full pl-8 gap-x-4">
          <img src="{{ $employee->avatar_url }}"  alt="{{ $employee->full_name }}'s Photo" class="w-24 h-24  mt-4" />
          <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
            {{ $employee->full_name }}
          </h1>
          <button type="button" wire:click="edit" class="button-employee">{{__('Edit')}}</button>
        </div>
      </div>
    </div>

    <div class=" grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
      <div class="flex items-center gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          Email
        </p>
        <p class="text-lg font-medium text">
          {{ $employee->email }}
        </p>
      </div>

      <div class="flex items-center gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Department')}}
        </p>
        <flux:badge class="{{ $employee->department->classes() }}">
          {{ $employee->department->label() }}
        </flux:badge>
      </div>

      <div class="flex items-center gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Position')}}
        </p>
        <flux:badge class="{{ $employee->position->classes() }}">
          {{ $employee->position->label() }}
        </flux:badge>
      </div>

      <div class="flex items-center gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Salary')}}
        </p>
        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
          {{ $employee->formatSalary() }}
        </p>
      </div>

      <div class="flex items-center gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Hire Date')}}
        </p>
        <p class="text-lg font-medium text-slate-900 dark:text-white">
          {{ $employee->formatHireDate() }}
        </p>
      </div>

      <div class="flex items-center gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Status')}}
        </p>
        <div class="mt-2">
          <flux:badge class="{{ $employee->status->classes() }}">
            {{ $employee->status->label() }}
          </flux:badge>
        </div>
      </div>
    <div class="flex items-center flex-col col-span-2 gap-x-12 rounded-xl min-h-28 border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
      <p class="uppercase text-sm font-extrabold mb-4 tracking-wider text-slate-500 dark:text-slate-400 text-left w-full">{{__('Notes')}}</p>
      <div class="employee-notes-content dark:text-slate-400 px-8 w-full">
        {!! $employee->notes !!}
      </div>
    </div>
    </div>
  </div>

  <x-employees.create-edit-modal
          name="edit-employee"
          :form="$form"
          :editing-employee="$editingEmployee"
          :departments="$departments"
          :positions="$positions"
          :statuses="$statuses"/>
</div>
