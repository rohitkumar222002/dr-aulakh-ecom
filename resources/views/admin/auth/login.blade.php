<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title',config('app.name'). " Admin Login")</title>
    <meta name="description" content="@yield('meta_description', config('app.name').' Admin Login'))" />
    <meta name="keywords" content="@yield('meta_keywords', config('app.name').' Admin Login')" />
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel/css/login.css') }}">
</head>

<body>
    <div class="container">
        <div class="right-section">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @livewire('auth.admin.admin-login')
        </div>
    </div>
</body>

</html>
