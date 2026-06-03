@if(count($selected) > 0)
  <div id="bulk-actions" class="mt-4 flex items-center justify-between w-fit dark:bg-transparent">
          <span class="border border-red-600/60 rounded-full p-2 mr-6">
            <flux:icon.bell-alert class="size 6 text-red-600/60 "/>
          </span>
              <span class="text-sm text-indigo-700 dark:text-white">
                {{ count($selected) }} {{ count($selected) > 1 ? __('employees selected') : __('employee selected') }}
            </span>
    <div class="flex gap-2 ml-6">
      <x-actions-button action="exportSelected" text="{{__('Export Selected')}}"/>
      <x-actions-button action="bulkDelete" text="{{__('Delete Selected')}}"
                        confirm="Are you sure you want to delete the selected employees?"/>
    </div>
  </div>
@endif
