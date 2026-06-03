@props([
  'action' => null,
  'text' => '',
  'route' => null,
  'confirm'=>null,
  'clases' =>'border-indigo-300 text-indigo-700 bg-indigo-100 hover:bg-indigo-200'
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
