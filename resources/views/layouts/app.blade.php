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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-brand-lightest h-screen font-sans">
    <div id="app">
        <nav class="h-pc-80 md:h-pc-131"></nav>
        <nav class="bg-white h-pc-80 md:h-pc-131 shadow fixed z-20 w-full pin-t">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-end md:h-pc-131 h-full">
                    <div class="md:absolute pin-l md:ml-pc-200 m-1 md:m-0 h-full flex items-center">
                        <a href="{{ url('/home') }}" class="no-underline">
                            <img src="/images/logo-long.png" class="w-3/4">
                        </a>
                        <div class="block md:hidden"><img @click="changeMenu" src="/images/menu.png" alt=""></div>
                    </div>
                    <div class="text-right md:flex items-center justify-around md:w-pc-800 hidden">
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/home') }}">首页</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/introduce') }}">医院介绍</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/dynamics') }}">医院动态</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/specials') }}">医疗特色</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">门诊预约</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/login') }}">在线取报告</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/register') }}">联系我们</a>
                    </div>
                </div>
            </div>
            <div id="menu" class="hidden w-full text-center flex-col bg-white opacity-75">
                <a href="{{ url('/home') }}" class="no-underline text-lg my-1 text-grey-darker">首页</a>
                <a href="{{ url('/introduce') }}" class="no-underline text-lg my-1 text-grey-darker">医院介绍</a>
                <a href="{{ url('/dynamics') }}" class="no-underline text-lg my-1 text-grey-darker">医院动态</a>
                <a href="{{ url('/specials') }}" class="no-underline text-lg my-1 text-grey-darker">医疗特色</a>
                <a href="" class="no-underline text-lg my-1 text-grey-darker">门诊预约</a>
                <a href="" class="no-underline text-lg my-1 text-grey-darker">在线去报告</a>
                <a href="" class="no-underline text-lg my-1 text-grey-darker">联系我们</a>
            </div>
        </nav>

        @yield('content')

        <footer class="container mx-auto md:mt-pc-176">
            <div class="flex md:flex-row justify-between flex-col m-4 md:m-0">
                <div class="flex flex-row md:pl-pc-50 md:w-pc-540 w-full justify-between">
                    <img src="/images/f-1.png" class="md:w-pc-165 md:h-pc-165 w-1/2 h-full">
                    <img src="/images/f-2.png" class="md:w-pc-165 md:h-pc-165 w-1/2 h-full">
                </div>
                <div class="md:w-pc-540 md:text-lg text-xs text-grey-darker leading-normal flex flex-col justify-center">
                    <p>地址：杭州市</p>
                    <p>电话：0571-56624893</p>
                    <p>版权所有：XXXX</p>
                    <p>宁波鄞州肛肠牙科医院</p>
                    <p>传真：0571-56624893</p>
                    <p>邮箱：xx@163.com</p>
                </div>
            </div>
            <div class="mt-4 md:mt-pc-50 h-pc-60 border-t border-grey-dark text-grey-dark text-base text-center flex flex-col md:flex-row items-center justify-center">
                © 2000-2017 DXY All rights reserved.<i>浙ICP备15034012号-2</i>浙公网安备 33010802005190号
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
