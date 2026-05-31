<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-2">
  <button wire:click="exportExcel"
          class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
    Export Excel
  </button>

  <button wire:click="exportPdf"
          class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
    Export PDF
  </button>

  <label
          class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 cursor-pointer">
    Import Excel
    <input type="file" wire:model="importFile" accept=".xlsx,.xls,.csv" class="hidden">
  </label>

  @if($importFile)
    <button wire:click="import"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700">
      __('Process Import')
    </button>
  @endif

  <a href="{{ route('employees.create') }}"
     class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
    {{ __('Add Employee')}}
  </a>
</div>
