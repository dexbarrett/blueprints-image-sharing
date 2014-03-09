<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel Image Sharing</title>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    {{ HTML::style('css/styles.css') }}
</head>
<body>
    <h2>Image Sharing Website</h2>
    @if(Session::has('errors'))
        <h3 class="error">{{ $errors->first() }}</h3>
    @endif
    @if(Session::has('error'))
        <h3 class="error">{{ Session::get('error') }}</h3>
    @endif
    @if(Session::has('success'))
        <h3 class="success">{{ Session::get('success') }}</h3>
    @endif
    @yield('content')
</body>
</html>