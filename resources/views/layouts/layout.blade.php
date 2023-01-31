<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SurveyApp - @yield('title')</title>
    @vite('resources/css/tailwind.css')
</head>

<body>
    @include('inc.header')

    <main class="container mx-auto px-3 md:px-5">
        @yield('content')
    </main>
</body>

</html>
