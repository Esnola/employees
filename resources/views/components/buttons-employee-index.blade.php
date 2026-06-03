<div class="flex justify-end gap-2">
  <button href="{{ route('employees.show', $employee) }}"
          wire:navigate
          class="button-employee border-blue-600 bg-blue-300/30 dark:bg-transparent text-blue-400">
    <flux:icon.eye class="size-4 mr-1"/>
    {{ __('View') }}
  </button>
  <flux:modal.trigger name="edit-employee">
  <button  wire:click="edit({{ $employee->id }})"
         {{-- href="{{ route('employees.edit', $employee) }}"
          wire:navigate--}}
          class="button-employee border-green-600 bg-green-300/30 dark:bg-transparent text-green-400">
    <flux:icon.pencil-square class="size-4 mr-1 -scale-x-100"/>
    {{ __('Edit') }}
  </button>
    </flux:modal.trigger>

  <flux:modal.trigger name="delete-employee">
  <button wire:click="confirmDelete({{ $employee->id }})"
          class="button-employee border-red-600 bg-red-300/30 dark:bg-transparent text-red-400">
    <flux:icon.trash class="size-4 mr-1"/>
    {{ __('Delete') }}
  </button>
    </flux:modal.trigger>
</div>
