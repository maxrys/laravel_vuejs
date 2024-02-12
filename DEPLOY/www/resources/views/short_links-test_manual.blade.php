<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel + VUE: Short Links Manual Tester</title>
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
        <style>
            #report {
                display: block;
                margin: 10px 0;
                padding: 20px;
                border: 3px solid red;
            }
            [data-type='forms-grid'] {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            [data-type='forms-grid'] form {
                flex: 200px;
            }
            [data-type='forms-grid'] form input {
                box-sizing: border-box;
                width: 100%;
            }
        </style>
        <script>
            function onSendLink() {
                event.preventDefault();
                let mount = document.getElementById('report');
                let data = {};
                Array.prototype.forEach.call(event.target.elements, element => {
                    if (element instanceof HTMLInputElement ||
                        element instanceof HTMLSelectElement)
                        data[element.name] = element.value;
                });
                console.log(JSON.stringify(data));
                testApi(data, mount);
            }
            function testApi(data, mount) {
                fetch(window.services.shortLinks.routeGenerate, {
                    method: 'post',
                    headers: {'x-csrf-token': window.scrf_token, 'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                }).then((response) => {
                    response.json().then((data) => {
                        let output = JSON.stringify(data);
                        if      (data.status === 'ok'     ) mount.innerHTML += `Service Ok: ${output}<br>`;
                        else if (data.status === 'warning') mount.innerHTML += `Service Warning: ${output}<br>`;
                        else if (data.status === 'error'  ) mount.innerHTML += `Service Error: ${output}<br>`;
                        else                                mount.innerHTML += `Service Error: Unknown status<br>`;
                    }).catch(error => {                     mount.innerHTML += `JSON Parse Error: ${error.message}<br>`; });
                })    .catch(error => {                     mount.innerHTML += `Network Error: ${error.message}<br>`; });
            }
        </script>
    </head>
    <body>
        <nav>
            <a href="{{ route('home') }}">Home</a>
        </nav>

        <h2>Short Links Manual Tester (pure Blade, no VUE, pure JS)</h2>

        <div id="report">
        </div>

        <div data-type="forms-grid">
            <form onsubmit="onSendLink()">
                <label>No link</label>
                <button type="submit">Test</button>
            </form>

            <form onsubmit="onSendLink()">
                <label>Variants</label>
                <select name="link">
                    <option value="">incorrect link: empty value</option>
                    <option value="http://">incorrect link: http://</option>
                    <option value="http://domain/path?query#anchor{{ str_repeat('abc', 2047) }}">incorrect link: to long value...</option>
                    <option value="http://domain">correct link: http://domain</option>
                    <option value="http://domain/path">correct link: http://domain/path</option>
                    <option value="http://domain/path?query">correct link: http://domain/path?query</option>
                    <option value="http://domain/path?query#anchor">correct link: http://domain/path?query#anchor</option>
                    <option value="{{ base64_decode('aHR0cHM6Ly90ZXN0c2FmZWJyb3dzaW5nLmFwcHNwb3QuY29tL3MvbWFsd2FyZS5odG1s') }}">correct link: !!! malware !!!</option>
                </select>
                <button type="submit">Test</button>
            </form>

            <form onsubmit="onSendLink()">
                <label>Custom value</label>
                <input type="text" name="link" value="{{ base64_decode('aHR0cHM6Ly90ZXN0c2FmZWJyb3dzaW5nLmFwcHNwb3QuY29tL3MvbWFsd2FyZS5odG1s') }}">
                <button type="submit">Test</button>
            </form>
        </div>

    </body>
</html>
