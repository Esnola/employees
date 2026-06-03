@props([
  'editingEmployee' => null,
  'departments' => [],
  'positions' => [],
  'statuses' => [],
  'submitAction' => 'update',
  'title' => null,
  'textbutton' => 'Update',
  'modalName' => 'edit-employee',
  'cancelRoute' => null,
])

<div class="w-full">
  <div class="md:flex md:items-center md:justify-between">
      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:tracking-wide pb-2">
        {{ $title ?? $editingEmployee?->full_name }}
      </h2>
  </div>
  <div class="mt-2 w-full!">
    <form wire:submit="{{ $submitAction }}">
      <div class="space-y-2 min-w-3xl">
        {{-- Personal Information --}}
        <div class="bg-white p-2 w-full shadow sm:rounded-lg dark:bg-gray-800">
          <div class="">
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
              <x-select-form :label="__('Department')" :for="'department'" :loop="$departments"/>
              <x-select-form :label="__('Position')" :for="'position'" :loop="$positions"/>
              <x-input-form for="salary" :label="__('Salary')" type="number" />
              <x-input-form for="hire_date" :label="__('Hire Date')" type="date"/>
              <x-select-form :label="__('Status')" :for="'status'" :loop="$statuses"/>
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <x-buttons-form :route="$cancelRoute" :modal-name="$modalName" :textbutton="$textbutton"/>
      </div>
    </form>
  </div>
</div>
