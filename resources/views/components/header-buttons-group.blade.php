@props([
  'importFile' => null,
  'clases' => "cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-transparent dark:text-white/60 dark:border-gray-400/30 dark:hover:bg-white/10"
])

<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-2">

  @if($importFile)
    <x-actions-button clases="{{$clases}}" action="import" text="{{__('Process Import')}}" />
  @else
    <x-actions-button clases="{{$clases}}" action="exportExcel" text="{{__('Export Excel')}}" />
    <x-actions-button clases="{{$clases}}"  action="exportPdf" text="{{__('Export PDF')}}" />
  @endif


  <label class="{{$clases}}" >
    {{__('Import Excel')}}
    <input type="file" wire:model="importFile" accept=".xlsx,.xls,.csv" class="hidden">
  </label>


  <x-actions-button clases="{{$clases}}" route="employees.create" text="{{ __('Add Employee') }}" />

</div>
