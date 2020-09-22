<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ore-magic-youtube</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/base.css') }}"/>
  </head>
  <body class="antialiased">
    <div
      class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex items-center">
          @foreach ($formats as $format)
          <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                @if (property_exists($format, 'url')) 
                  <a href="{{ $format->url }}" target="_blank">{{ $format->itag }}</a>
                @endif
            </div>
          </div>
          @endforeach
        </div>
        <div class="flex items-center">
          <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                <a href="{{ $originalUrl }}" target="_blank">youtube</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </body>
</html>
