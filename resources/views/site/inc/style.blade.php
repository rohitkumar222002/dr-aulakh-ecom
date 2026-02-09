<title>@yield('meta_title',get_setting('meta_title'))</title>
<meta name="description" content="@yield('meta_description',get_setting('meta_description'))"/>
<meta name="keywords" content="@yield('meta_keywords',get_setting('meta_keywords'))"/>
<meta name="author" content="{{ config('app.name') }}"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
@yield('meta-site')
@if (!Route::is('store.detail'))
<meta property="og:site_name" content="{{ config('app.name') }}"/>
<meta property="og:title" content="@yield('meta_title',get_setting('meta_title'))"/>
<meta property="og:description" content="@yield('meta_keywords',get_setting('meta_keywords'))"/>
<meta property="og:image:width" content="400"/>
<meta property="og:image:height" content="600"/>
<meta property="og:image" content="@yield('meta_image', uploaded_asset(get_setting('web_logo')))"/>


<meta property="og:url" content="{{ url()->current() }}"/>
<meta property="og:type" content="website" />
<meta name="twitter:title" content="@yield('meta_title', get_setting('meta_title'))"/>
<meta name="twitter:description" content="@yield('meta_description', get_setting('meta_description'))"/>
<meta name="twitter:image" content="@yield('meta_image', uploaded_asset(get_setting('web_logo')))"/>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
@if (get_setting('favicon'))
<link rel="icon" type="image/x-icon" href="{{ uploaded_asset(get_setting('favicon')) }}">
@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('site/style.css') }}">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@livewireStyles
@yield('site-styles')
@stack('site-styles')
