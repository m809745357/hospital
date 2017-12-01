<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body class="bg-brand-lightest h-screen font-sans">
    <div id="app">
        <nav class="bg-white md:h-pc-131 shadow">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-end md:h-pc-131">
                    <div class="md:absolute pin-l md:ml-pc-200">
                        <a href="{{ url('/') }}" class="no-underline">
                            <img src="/images/logo-long.png" alt="">
                        </a>
                    </div>
                    <div class="text-right md:flex items-center justify-around md:w-pc-800 hidden">
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">首页</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">医院介绍</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">医院动态</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">医院特色</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">门诊预约</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">在线取报告</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/register') }}">联系我们</a>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
