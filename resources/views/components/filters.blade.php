{{-- Department Filter --}}
<div class="w-full md:w-48">
  <select wire:model.live="department"
          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    <option value="">{{__('All Departments')}}</option>
    @foreach($this->departments as $dept)
      <option value="{{ $dept }}">{{ __($dept->value) }}</option>
    @endforeach
  </select>
</div>

{{-- Positions Filter --}}
<div class="w-full md:w-48">
  <select wire:model.live="position"
          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    <option value="">{{__('All Positions')}}</option>
    @foreach($this->positions as $position)
      <option value="{{ $position }}">{{ __($position->value )}}</option>
    @endforeach
  </select>
</div>

{{-- Status Filter --}}
<div class="w-full md:w-40">
  <select wire:model.live="status"
          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    <option value="">{{__('All Status')}}</option>
    @foreach($this->statuses as $statusOption)
      <option value="{{ $statusOption->value }}">{{ ucfirst( __($statusOption->value)) }}</option>
    @endforeach
  </select>
</div>
