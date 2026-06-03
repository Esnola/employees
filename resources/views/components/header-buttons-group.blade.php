@props([
  'importFile' => null,
  'clases' => "border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-transparent dark:text-white/60 dark:border-gray-400/30 dark:hover:bg-white/10 cursor-pointer items-center px-3 py-2 border text-sm font-medium rounded-md"
])

<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-2">

  <div class="w-full md:w-40 ">
    @if ($this->hasActiveFilters())
    <x-actions-button  clases="{{$clases}}"
                       action="resetFilters"
                       text="{{ __('Reset Filters') }}" />
      @endif
  </div>

  @if($importFile)
    <x-actions-button action="import" text="{{__('Process Import')}}" />
  @else
    <x-actions-button action="exportExcel" text="{{__('Export Excel')}}" />
    <x-actions-button action="exportPdf" text="{{__('Export PDF')}}" />
  @endif


  <label class="{{$clases}}" for="importFile" >
    {{__('Import Excel')}}
    <input type="file" wire:model="importFile" accept=".xlsx,.xls,.csv" class="hidden">
  </label>


  <flux:modal.trigger name="create-employee">
    <button
            type="button"
            wire:click="create"
            class="{{$clases}}">
      {{ __('Add Employee') }}
    </button>
  </flux:modal.trigger>

</div>
