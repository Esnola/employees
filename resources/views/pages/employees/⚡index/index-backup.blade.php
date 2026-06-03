<div class="px-4 sm:px-6 lg:px-8">
  {{-- Header --}}
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <p class="mt-2 text-sm text-gray-700">
        {{ __('A list of all employees including their name, email, department, and status.') }}
      </p>
    </div>

    {{--Import, Export and Create new buttons --}}
    <x-header-buttons-group :importFile="$importFile"/>

    @if (session()->has('error'))
      <div class="mt-4 rounded-md bg-red-50 p-4">
        <div class="flex">
          <div class="ml-3">
            <p class="text-sm font-medium text-red-800">
              {{ session('error') }}
            </p>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- Flash Message --}}
  @if (session()->has('message'))
    <x-flash-message/>
  @endif

  <div class="mt-8 flex flex-col md:flex-row md:items-center gap-2">
    {{-- Filters & Search --}}
    <x-search/>
    <x-filters/>
  </div>


  {{-- Bulk Actions --}}
  @if(count($selected) > 0)
    <div id="bulk-actions" class="mt-4 bg-indigo-50 p-4 rounded-md flex items-center justify-between ">
            <span class="text-sm text-indigo-700">
                {{ count($selected) }}  {{ count($selected) > 1 ? __('employees selected') : __('employee selected') }}
            </span>
      <div class="flex gap-2">
        <x-actions-button action="exportSelected" text="{{__('Export Selected')}}"/>
        <x-actions-button action="bulkDelete" text="{{__('Delete Selected')}}"
                          confirm="Are you sure you want to delete the selected employees?"
                          clases=" border-red-300 text-red-700 bg-red-100 hover:bg-red-200"/>
      </div>
    </div>
  @endif

  {{-- Table --}}
  <div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="overflow-hidden shadow ring-1 ring-gray-500/10 ring-opacity-5 md:rounded-lg dark:ring-gray-500/30">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                <input type="checkbox" wire:model.live="selectAll"
                       class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6">
              </th>

              {{-- Sortable Name Column --}}
              <x-shortable-th field="first_name" :sortDirection="$sortDirection" :sortField="$sortField"
                              text="{{__('Name')}}"/>

              {{-- Email --}}
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Email
              </th>

              {{-- Sortable Department --}}
              <x-shortable-th field="department" :sortDirection="$sortDirection" :sortField="$sortField"
                              text="{{__('Department')}}"/>

              {{-- Sortable Position --}}
              <x-shortable-th field="position" :sortDirection="$sortDirection" :sortField="$sortField"
                              text="{{__('Position')}}"/>

              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                {{__('Status') }}
              </th>

              {{-- Actions --}}
              <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                {{ __('Actions') }}
                <span class="sr-only">Actions</span>
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($this->employees as $employee)
              <tr wire:key="employee-{{ $employee->id }}" class="hover:bg-gray-50">
                <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                  <input type="checkbox" wire:model.live="selected" value="{{ $employee->id }}"
                         class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6">
                </td>

                <td class="whitespace-nowrap px-3 py-4 text-sm">
                  <flux:link class="font-medium no-underline! hover:underline text-stone-400 hover:text-stone-500"
                             href="{{route('employees.show', $employee)}}">{{ $employee->full_name }}
                  </flux:link>
                </td>

                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  {{ $employee->email }}
                </td>

                <td class="whitespace-nowrap px-3 py-4">
                  <flux:badge
                          class="{{$employee->department->classes()}}">{{ __($employee->department->value) }}</flux:badge>
                </td>

                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  <flux:badge
                          class="{{$employee->position->classes()}}">{{ __($employee->position->value) }}</flux:badge>
                </td>

                <td class="whitespace-nowrap px-3 py-4 text-sm">
                  <span class="inline-flex rounded-md px-2 text-xs font-semibold leading-5 border
                      {{ $employee->status->classes() }}">
                      {{ ucfirst(__($employee->status->value)) }}
                      </span>
                </td>
                {{-- Action Buttons for Every Employee --}}
                <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <x-buttons-employee-index :employee="$employee"/>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-3 py-8 text-center text-sm text-gray-500">
                  {{ __('No employees found.')}}
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Pagination --}}
  <div class="mt-4">
    {{ $this->employees->links() }}
  </div>

 {{-- Edit Flux Modal --}}

  <flux:modal flyout variant="floating" :dismissible="false" name="edit-employee">
    <x-employees.edit-employee/>
  </flux:modal>


  {{-- Delete Confirmation Modal --}}
{{--@if($showDeleteModal)--}}
  <flux:modal  variant="floating" :dismissible="false" name="delete-employee" class="min-w-dvw min-h-full">
    <x-employees.delete-employee :employeename="$employee?->full_name" :id="$employee->id" />
    </flux:modal>
 {{-- @endif--}}
</div>
