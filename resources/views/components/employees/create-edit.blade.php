@props([
  'form',
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
        {{-- Photo / Avatar --}}
        <div class="bg-white shadow sm:rounded-lg dark:bg-gray-800">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900/8033 mb-4">
              {{ __('Photo') }}
            </h3>

            @if ($editingEmployee?->photo)
              <label class="text-sm text-gray-700 dark:text-gray-300 mt-4">
                <input
                        wire:model.live="form.removePhoto"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                {{ __('Remove current photo') }}
              </label>
            <div class="mt-3 my-6">
              @if ($form->photo && str_starts_with((string) $form->photo->getMimeType(), 'image/'))
                <img src="{{ $form->photo->temporaryUrl() }}" alt="{{ __('Selected photo preview') }}"
                     class="h-24 w-24 rounded-md object-cover">
              @elseif ($editingEmployee?->photo && ! $form->removePhoto)
                <img src="{{ $editingEmployee->avatar_url }}" alt="{{ $editingEmployee->full_name }}"
                     class="h-24 w-24 rounded-md object-cover">
              @endif
            </div>
              @endif
            <div>
              <!-- Input real oculto pero accesible -->
              <input wire:model="form.photo" type="file" id="photo" accept="image/*" class="hidden">

              <label for="photo" class="mt-1 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 cursor-pointer dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700
">
                <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{$editingEmployee?->photo ?__('Change Photo'):__('Upload Photo')}}</span>
              </label>
              @error('form.photo')
              <p class="mt-1 text-sm text-red-600!">{{ $message }}</p>
              @enderror
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
              <x-input-form for="salary" :label="__('Salary')" type="number" step="0.01"/>
              <x-input-form for="hire_date" :label="__('Hire Date')" type="date"/>
              <x-select-form :label="__('Status')" :for="'status'" :loop="$statuses"/>
          </div>
            <div class="mt-4 w-full">
              {{-- Notes--}}
              <x-html-editor model="form.notes" :label="__('Notes')" />
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <x-buttons-form :route="$cancelRoute" :modal-name="$modalName" :textbutton="$textbutton"/>
      </div>
    </form>
  </div>
</div>
