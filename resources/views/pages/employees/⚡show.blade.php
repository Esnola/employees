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

<div class="max-w-5xl mx-auto p-6">
  <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg dark:border-slate-800 dark:bg-slate-950">
    <div class="bg-linear-to-r from-sky-700 to-sky-800 sm:px-6  py-8 text-slate-100/70">
      <div class="flex items-center justify-around  w-full sm:w-2/3">
        <a href="{{route('employees.index')}}"
           class="text-slate-100/70 hover:text-slate-100 text-sm flex gap-2 items-center">
          <flux:icon.bars-arrow-up class="w-6 h-6 -rotate-90 group-hover:text-white"/>
          {{__('Employees List')}}
        </a>
        <div class="">
          <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
            {{ $employee->full_name }}
          </h1>
          <a href="{{route('employees.edit',$employee)}}" class="button-employee">{{__('Edit')}}</a></div>
      </div>
    </div>

    <div class=" grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
      <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          Email
        </p>
        <p class="mt-2 text-lg font-medium text-slate-900 dark:text-white">
          {{ $employee->email }}
        </p>
      </div>

      <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Department')}}
        </p>
        <flux:badge class="{{ $employee->department->classes() }}">
          {{ $employee->department->value }}
        </flux:badge>
      </div>

      <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Position')}}
        </p>
        <flux:badge class="{{ $employee->position->classes() }}">
          {{ $employee->position }}
        </flux:badge>
      </div>

      <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Salary')}}
        </p>
        <p class="mt-2 text-lg font-bold text-emerald-600 dark:text-emerald-400">
          {{ $employee->formatSalary() }}
        </p>
      </div>

      <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Hire Date')}}
        </p>
        <p class="mt-2 text-lg font-medium text-slate-900 dark:text-white">
          {{ $employee->formatHireDate() }}
        </p>
      </div>

      <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
          {{__('Status')}}
        </p>
        <div class="mt-2">
          <flux:badge class="{{ $employee->status->classes() }}">
            {{ $employee->status->value }}
          </flux:badge>
        </div>
      </div>
    </div>
  </div>
</div>
