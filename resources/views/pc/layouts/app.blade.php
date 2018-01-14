<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.description') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>
        window.App = <?php echo json_encode([
            'user' => Auth::user(),
            'signedIn' => Auth::check(),
            'banners' => App\Models\Banner::where('status', 1)->latest()->get(),
            'configs' => App\Models\Config::all()->pluck('contact', 'slug'),
            'qrcode' => 'data:image/png;base64, ' . base64_encode(QrCode::format('png')->size(400)->generate(route('advance.index')))
        ]); ?>
    </script>
    <!-- Styles -->
    <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=TPDBZ-6CC3P-RLDDE-VOYUL-DIKDQ-PHBS7"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-brand h-screen font-sans">
    <div id="app">
        <nav class="h-pc-80 md:h-pc-131"></nav>
        <nav class="bg-white h-pc-80 md:h-pc-131 shadow fixed z-20 w-full pin-t">
            <div class="container mx-auto h-full" v-cloak>
                <div class="flex items-center justify-end md:h-pc-131 h-full">
                    <div class="md:absolute pin-l md:ml-pc-200 m-1 md:m-0 h-full flex items-center">
                        <a href="{{ url('/home') }}" class="no-underline w-3/4 md:w-full">
                            <img :src="'/uploads/' + configs.logo" class="w-full md:w-374px">
                        </a>
                        <div class="block md:hidden flex-1 text-right"><img @click="changeMenu" src="/images/menu.png" alt=""></div>
                    </div>
                    <div class="text-right md:flex items-center justify-around md:w-pc-800 hidden">
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/home') }}">首页</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/introduce') }}">医院介绍</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/dynamics') }}">医院动态</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/specials') }}">医疗特色</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/schedulings') }}">门诊预约</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/report') }}">在线取报告</a>
                        <a class="no-underline hover:underline hover:text-blue text-grey-darker text-lg" href="{{ url('/contact') }}">联系我们</a>
                    </div>
                </div>
            </div>
            <div id="menu" class="hidden w-full text-center flex-col bg-white opacity-75">
                <a href="{{ url('/home') }}" class="no-underline text-lg my-1 text-grey-darker">首页</a>
                <a href="{{ url('/introduce') }}" class="no-underline text-lg my-1 text-grey-darker">医院介绍</a>
                <a href="{{ url('/dynamics') }}" class="no-underline text-lg my-1 text-grey-darker">医院动态</a>
                <a href="{{ url('/specials') }}" class="no-underline text-lg my-1 text-grey-darker">医疗特色</a>
                <a href="{{ url('/schedulings') }}" class="no-underline text-lg my-1 text-grey-darker">门诊预约</a>
                <a href="{{ url('/report') }}" class="no-underline text-lg my-1 text-grey-darker">在线取报告</a>
                <a href="{{ url('/contact') }}" class="no-underline text-lg my-1 text-grey-darker">联系我们</a>
            </div>
        </nav>
        <div class="flex items-center w-full flex-col" v-cloak>
            <div class="w-full">
                <swiper :options="bannerOptions">
                    <swiper-slide v-for="(slide, index) in swiperSlides" :key="index">
                        <img :src="'/uploads/' + slide.image" alt="">
                        <a :href="slide.url" class="banner-button hidden md:block" v-html="slide.title"></a>
                    </swiper-slide>
                    <div class="swiper-pagination" slot="pagination"></div>
                </swiper>
            </div>
            @yield('content')
        </div>
        <footer class="container mx-auto md:mt-pc-176" v-cloak>
            <div class="flex md:flex-row justify-between flex-col m-4 md:m-0">
                <div class="flex flex-row md:pl-pc-50 md:w-pc-540 w-full justify-between">
                    <img :src="'/uploads/' + configs.bottom_logo" class="md:w-pc-165 md:h-pc-165 w-1/2 h-full">
                    <img :src="'/uploads/' + configs.qrcode" class="md:w-pc-165 md:h-pc-165 w-1/2 h-full">
                </div>
                <?php $configs = App\Models\Config::all()->pluck('contact', 'slug'); ?>
                <div class="md:w-pc-540 md:text-lg text-xs text-grey-darker leading-normal flex flex-col justify-center">
                    <p>{{ $configs['site_title'] }}</p>
                    <p>地址：{{ $configs['address'] }}</p>
                    <p>电话：{{ $configs['phone'] }}</p>
                    <p>网址：{{ $configs['url'] }}</p>
                    <p>邮箱：{{ $configs['mail'] }}</p>
                </div>
            </div>
            <div class="mt-4 md:mt-pc-50 h-pc-60 border-t border-grey-dark text-grey-dark text-base text-center flex flex-col md:flex-row items-center justify-center">
                © 2000-2017 DXY All rights reserved.<i>浙ICP备17052777号-1</i>浙公网安备 号
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
