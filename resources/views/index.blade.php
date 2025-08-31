<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CWI - @yield('module', 'Home')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('logo.png')}}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>
<header>
<x-navbar></x-navbar>
</header>
<body>
@if($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notyf = new Notyf({
                duration: 5000,
                position: { x: 'center', y: 'top' },
                types: [
                    {
                        type: 'error',
                        background: 'var(--color-error)',
                        icon: { className: 'icon-[tabler--error-404] !text-error', tagName: 'i' },
                        text: '',
                        color: 'white'
                    }
                ]
            });

            @foreach($errors->all() as $error)
            notyf.open({
                type: 'error',
                message: {!! json_encode($error) !!},
                ripple: true,
                dismissible: true
            });
            @endforeach
        });
    </script>
@endif
@yield('content')
</body>
<footer>
    <select label="Choose Theme" data-choose-theme>
        <option value="">Default</option>
        <option value="light">Light</option>
        <option value="dark">Dark</option>
        <option value="black">Black</option>
    </select>

</footer>
</html>
