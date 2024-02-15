<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel + VUE: Short Links Generator</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
        <script>
            window.scrf_token = '{{ csrf_token() }}';
            window.services = {
                shortLinks: {
                    max_length:    '{{ App\Models\ShortLinks::LINK_MAX_LENGTH }}',
                    routeGenerate: '{{ route('short_links_api_generate') }}',
                    routeGo:       '{{ route('short_links_go', ['hash' => '%%_hash']) }}'
                }
            }
        </script>
        <script src="{{ asset('js/short_links-app.js') }}" defer></script>
    </head>
    <body>
        <nav>
            <a href="{{ route('home') }}">Home</a>
        </nav>
        <div id="app">
        </div>
    </body>
</html>
