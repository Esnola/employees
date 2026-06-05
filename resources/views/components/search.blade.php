@props([
  'search' => '',
])

<div class="flex-1 flex items-center">
  <input wire:model.live.debounce.300ms="search"
          type="text" placeholder="{{ __('Search employees') }}..."
          class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
  @if($search)
  <button
          type="button"
          wire:click="$set('search', '')"
          class="flex cursor-pointer items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2 dark:bg-transparent dark:text-gray-400 dark:border-gray-600 dark:hover:bg-white/10 dark:hover:text-white dark:hover:border-white">
    <flux:icon.x-circle class="size-6"/>
  </button>
  @endif
</div>
