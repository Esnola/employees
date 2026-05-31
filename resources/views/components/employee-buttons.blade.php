<div class="flex justify-end gap-2">
  <button href="{{ route('employees.show', $employee) }}"
          wire:navigate
          class="button-employee border-blue-600 bg-blue-100/50 text-blue-400">
    <flux:icon.eye class="size-4 mr-1"/>
    {{ __('View') }}
  </button>
  <button href="{{ route('employees.edit', $employee) }}"
          wire:navigate
          class="button-employee border-green-600 bg-green-100/50 text-green-400">
    <flux:icon.pencil-square class="size-4 mr-1 -scale-x-100"/>
    {{ __('Edit') }}
  </button>
  <button wire:click="confirmDelete({{ $employee->id }})"
          class="button-employee border-red-600 bg-red-100/50 text-red-400">
    <flux:icon.trash class="size-4 mr-1"/>
    {{ __('Delete') }}
  </button>
</div>
