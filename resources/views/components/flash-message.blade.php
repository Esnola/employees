@php
  $message = session('message') ?? session('error');
  $type = session('error') ? 'error' : session('message_type', 'success');

  $styles = [
    'success' => [
      'container' => 'bg-emerald-50 border-emerald-400 dark:bg-emerald-100/90 dark:border-emerald-500',
      'icon' => 'text-green-400 dark:text-green-500/50',
      'text' => 'text-emerald-600!',
      'button' => 'text-green-500 bg-green-500/20 hover:bg-green-500/30 hover:border-green-500',
      'path' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z',
    ],
    'info' => [
      'container' => 'bg-sky-50 border-sky-400 dark:bg-sky-100/90 dark:border-sky-500',
      'icon' => 'text-sky-500 dark:text-sky-600/70',
      'text' => 'text-sky-700!',
      'button' => 'text-sky-600 bg-sky-500/20 hover:bg-sky-500/30 hover:border-sky-500',
      'path' => 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zM9 9a1 1 0 012 0v5a1 1 0 11-2 0V9zm1-4a1.25 1.25 0 100 2.5A1.25 1.25 0 0010 5z',
    ],
    'error' => [
      'container' => 'bg-red-50 border-red-400 dark:bg-red-100/90 dark:border-red-500',
      'icon' => 'text-red-500 dark:text-red-600/70',
      'text' => 'text-red-700!',
      'button' => 'text-red-600 bg-red-500/20 hover:bg-red-500/30 hover:border-red-500',
      'path' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293L10 8.586l1.293-1.293a1 1 0 111.414 1.414L11.414 10l1.293 1.293a1 1 0 01-1.414 1.414L10 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L8.586 10 7.293 8.707a1 1 0 011.414-1.414z',
    ],
  ];

  $style = $styles[$type] ?? $styles['success'];
@endphp

@if ($message)
<div x-data="{ show: false }"
     x-init="$nextTick(() => {
      requestAnimationFrame(() => show = true);
      setTimeout(() => show = false, 3000);
      })"
     x-show="show"
     x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-4 -right-2 sm:left-auto sm:w-full sm:max-w-md rounded text-sx border z-50 shadow-lg transform-gpu flex p-2 items-center justify-between px-6 {{ $style['container'] }}" role="alert">

      <svg class="h-5 w-5 {{ $style['icon'] }}" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="{{ $style['path'] }}"
              clip-rule="evenodd"/>
      </svg>

      <p class="text-sm font-medium {{ $style['text'] }}">
        {{ $message }}
      </p>

      <button
              @click="show = false"
              class="cursor-pointer flex gap-2 items-center rounded-md p-1 text-xs border border-transparent mr-2 {{ $style['button'] }}"
              aria-label="{{__('Close')}}" >
        <svg class="h-4 w-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span class="sr-only">{{__('Close')}}</span>
      </button>
</div>
@endif
