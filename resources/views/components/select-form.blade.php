<div class="">
  <label for="{{$for}}" class="block text-sm font-medium text-gray-700">
    {{$label}}
  </label>
  <select wire:model="form.{{$for}}" id="{{$for}}">
    @foreach($loop as $data)
      <option value="{{ $data }}">{{ ucfirst($data->value) }}</option>
    @endforeach
  </select>
  @error("form.{{$for}}")
  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
