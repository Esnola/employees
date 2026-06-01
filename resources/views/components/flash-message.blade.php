<div x-data="{ show: true }"
     x-show="show"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-1"
     class="mt-4 rounded-md p-4 bg-green-200/20 text-green-700 border border-green-500/50 shadow-sm "
>
  <div class="flex items-center">
    <div class="shrink-0">
      <svg class="h-5 w-5 text-green-400 dark:text-green-500/50" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"/>
      </svg>
    </div>
    <div class="ml-3 flex-1">
      <p class="text-sm font-medium">
        {{ session('message') }}
      </p>
    </div>
    <div class="mx-auto">
      <button
              @click="show = false"
              class="cursor-pointer flex gap-2 items-center rounded-md p-1.5 text-green-500 bg-green-500/20 hover:bg-green-500/30 border border-transparent hover:border-green-500"
              aria-label="Cerrar" >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span class="sr-only">{{__('Close')}}</span>
        {{__('Close')}}
      </button>
    </div>
  </div>
</div>
