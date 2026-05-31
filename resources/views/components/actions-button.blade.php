@props([
  'action' => null,
  'text' => '',
  'route' => null,
  'clases' =>' '
])

<button
        @if($route)
          wire:click="gotoButton('{{ $route }}')"
        @elseif($action)
          wire:click="{{ $action }}"
        @endif
        class="{{$clases}} " >
  {{ $text }}
</button>
