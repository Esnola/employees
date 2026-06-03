@props([
  'action' => null,
  'text' => '',
  'route' => null,
  'confirm'=>null,
  'clases' =>'border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-transparent dark:text-white/60 dark:border-gray-400/30 dark:hover:bg-white/10'
])

<button
        @if($route)
          wire:click="gotoButton('{{ $route }}')"
        @elseif($action)
          wire:click="{{ $action }}"
        @endif
         @if($confirm)
         wire:confirm="{{ $confirm }}"
          @endif
        class="{{$clases}} cursor-pointer items-center px-3 py-2 border text-sm font-medium rounded-md" >
  {{ $text }}
</button>
