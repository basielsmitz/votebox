<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Votebox</title>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'api_token' => Auth::user()->api_token,

            ]) !!}
    </script>

</head>
<body>

<div id="app">
    {{--<p v-text="message"></p>--}}
    <navigation></navigation>
    <vuehead ></vuehead>
    <vueheadDesktop></vueheadDesktop>
    <transition name="slide">
        <router-view ></router-view>
    </transition>
</div>

<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
<script src="{{ URL::asset('js/vue.js') }}" ></script>
<script src="{{ URL::asset('js/main.js') }}" ></script>


</body>
</html>