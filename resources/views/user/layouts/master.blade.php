<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,400;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('assets/css/style-starter.css')}}">


    @yield('style')
</head>
<body>

    @include('user.layouts.navbar')

    @yield('content')

    @include('user.layouts.footer')

    @yield('script')
    
</body>
</html>