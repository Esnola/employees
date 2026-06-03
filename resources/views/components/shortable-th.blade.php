<th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
  <button type="button" wire:click="sortBy('{{ $field }}')" class="flex items-center gap-2 cursor-pointer">
    {{ $text }}
    @if($sortField === $field)
      <span>
        @if($sortDirection === 'asc')
          ↑
        @else
          ↓
        @endif
      </span>
    @endif
  </button>
</th>
