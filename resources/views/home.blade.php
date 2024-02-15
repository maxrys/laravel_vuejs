<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel + VUE: home</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
    </head>
    <body>
        <nav>
            <ul>
                <li> <a href="{{ route('short_links_generate') }}">Short Links Generator</a> </li>
                <li> <a href="{{ route('short_links_test_manual') }}">Short Links Test Manual</a> </li>
            </ul>
        </nav>
        <div>
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} |
            PHP     v{{ PHP_VERSION }}
        </div>
    </body>
</html>
