
<div class="px-4 sm:px-6 lg:px-8">
  <div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1 flex gap-2 items-center">
      <h2 class="text-2xl font-bold leading-7 text-gray-900/80 sm:truncate sm:text-3xl sm:tracking-tight">
        {{ __('Edit Employee')}}: {{ $this->employee->full_name }}
      </h2>
      <flux:icon.user class="size-6"/>
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
              <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">
                  {{ __('First Name')}}
                </label>
                <input wire:model.blur="form.first_name" type="text" id="first_name" >
                @error('form.first_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Last Name --}}
              <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">
                  {{ __('Last Name')}}
                </label>
                <input wire:model.blur="form.last_name" type="text" id="last_name" >
                @error('form.last_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Email --}}
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                  Email
                </label>
                <input wire:model.blur="form.email" type="email" id="email" >
                @error('form.email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Phone --}}
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">
                  Phone
                </label>
                <input wire:model="form.phone" type="text" id="phone" >
                @error('form.phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
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
              <div>
                <label for="department" class="block text-sm font-medium text-gray-700">
                  {{__('Department')}}
                </label>
                <select wire:model="form.department" id="department"
                >
                  <option value="">Select Department</option>
                  @foreach($departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                  @endforeach
                </select>
                @error('form.department')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Position --}}
              <div>
                <label for="position" class="block text-sm font-medium text-gray-700">
                  {{__('Position')}}
                </label>
                <select wire:model="form.position" id="position">
                  <option value="">Select Position</option>
                  @foreach($positions as $pos)
                    <option value="{{ $pos }}">{{ $pos }}</option>
                  @endforeach
                </select>
                @error('form.position')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Salary --}}
              <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">
                  {{__('Salary')}}
                </label>
                <input wire:model.blur="form.salary" type="number" id="salary" step="0.01">
                @error('form.salary')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Hire Date --}}
              <div>
                <label for="hire_date" class="block text-sm font-medium text-gray-700">
                  {{__('Hire Date')}}
                </label>
                <input wire:model="form.hire_date" type="date" id="hire_date">
                @error('form.hire_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Status --}}
              <div class="sm:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700">
                  {{__('Status')}}
                </label>
                <select wire:model="form.status" id="status">
                  @foreach($statuses as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                  @endforeach
                </select>
                @error('form.status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
