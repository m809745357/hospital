<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>  

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>
        window.App = <?php echo json_encode([
            'user' => Auth::user()->load('promoter'),
            'signedIn' => Auth::check(),
            'configs' => App\Models\Config::all()->pluck('contact', 'slug'),
            'promoter' => Auth::user()->promoter()->exists() ? 'data:image/png;base64, ' . base64_encode(QrCode::format('png')->size(400)->generate(route('promoter.order.create', array('promoter' => Auth::user()->promoter->id)))) : false,
            'wxconfig' => config('app.debug') ? '' : $js->config(array(
               'onMenuShareTimeline',
               'onMenuShareAppMessage',
               'onMenuShareQQ',
               'onMenuShareWeibo',
               'onMenuShareQZone',
            ), false)
        ]); ?>
    </script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-brand h-screen font-sans">
    <div id="app">
        @yield('content')
    </div>
    @if (config('app.debug'))
        @include('sudosu::user-selector')
    @endif
    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
