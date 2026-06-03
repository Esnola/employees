<div class="sm:flex sm:items-start">
  <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
         stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
    </svg>
  </div>

  <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">
      {{__('Delete Employee')}}: {{ $employeename }}
    </h3>

    <div class="mt-2">
      <p class="text-sm text-gray-500 dark:text-gray-300">
        {{ __('Are you sure you want to delete this employee? This action cannot be undone.')}}
      </p>
    </div>
  </div>
</div>

<div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
  <button wire:click="deleteEmployee"
          type="button"
          class="cursor-pointer inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
    {{__('Delete')}}
  </button>

  <button type="button"
          data-close-flux-modal="delete-employee"
          class="cursor-pointer mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
    {{__('Cancel')}}
  </button>
</div>
