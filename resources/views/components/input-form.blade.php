
<div>
  <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">
    {{ $label }}
  </label>
  <input wire:model="form.{{ $for }}" type="{{ $type }}" id="{{ $for }}">
  @error("form." . $for)
  <p class="mt-1 text-sm text-red-600!">{{ $message }}</p>
  @enderror
</div>
