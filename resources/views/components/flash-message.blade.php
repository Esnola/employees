<div x-data="{ show: false }"
     x-init="$nextTick(() => { requestAnimationFrame(() => show = true); setTimeout(() => show = false, 116000); })"
     x-show="show"
     x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-4 -right-2 sm:left-auto sm:w-full sm:max-w-md rounded text-sx bg-emerald-50 border border-emerald-400 z-50 shadow-lg transform-gpu dark:bg-emerald-100/90 dark:border-emerald-500 flex p-2 items-center justify-between px-6" role="alert">


      <svg class="h-5 w-5 text-green-400 dark:text-green-500/50" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"/>
      </svg>


      <p class="text-sm font-medium text-emerald-600!">
        {{ session('message') }}
      </p>

      <button
              @click="show = false"
              class="cursor-pointer flex gap-2 items-center rounded-md p-1 text-xs text-green-500 bg-green-500/20 hover:bg-green-500/30 border border-transparent hover:border-green-500 mr-2"
              aria-label="{{__('Close')}}" >
        <svg class="h-4 w-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span class="sr-only">{{__('Close')}}</span>
      </button>

</div>
