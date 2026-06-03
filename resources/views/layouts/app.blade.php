<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @fluxAppearance
  @livewireStyles
  <title>{{ $title ?? __('Employee Management') }}</title>
</head>
<body class="bg-gray-50 antialiased dark:bg-gray-800">
<nav class="shadow-sm border-b border-gray-200 dark:border-gray-700">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <h1 class="text-xl font-bold">
          {{ __('Employees Management') }}
        </h1>
    <div class="flex items-center gap-4">
      <livewire:language-toggle/>
      <x-darkmode-switch/>
    </div>
  </div>
</nav>

<main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
  {{ $slot }}
</main>
@livewireScripts
@fluxScripts
</body>
</html>
