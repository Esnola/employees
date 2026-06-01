<th wire:click="sortBy('{{$field}}')"
    class="cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
  <div class="flex items-center gap-2">
    {{ $text  }}
      @if($sortField === $field )
      <span>
       @if($sortDirection === 'asc')
          ↑
        @else
          ↓
        @endif
        </span>
    @endif
  </div>
</th>
