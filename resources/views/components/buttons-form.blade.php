@props([
  'route' => null,
  'textbutton' => '',
  'class' => 'cursor-pointer border border-transparent rounded-md py-2 px-4 text-sm font-medium  shadow-sm  focus:outline-none focus:ring-2 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600'
  ])

<div class="flex justify-end gap-3">
<buton href="{{ $route }}"
        wire:navigate
    class="{{$class}} border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-gray-500 focus:ring-offset-gray-100">
  {{__('Cancel')}}
</buton>
<button type="submit"
        class="{{$class}} bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500">
  {{$textbutton}}
</button>
</div>
