<!--Una volta fatto l'accesso si attera in questa pagina dove si vede l'header e un benvenuto -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body>
    @include('include.header')
    @extends('login/layout')
    @section('content')
        <div class="container">
            <h1>Benvenuto</h1>
        </div>
    @endsection
</body>

</html>
