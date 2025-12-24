<!DOCTYPE html>
<html dir="{{ (app()->getLocale() === 'ar') ? 'rtl' : 'ltr' }}" lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{url('images/logo.jpg')}}"/>
    <title>@yield('title')</title>

    {{-- styles --}}
    <link rel="stylesheet" href="{{url('package/swiper-bundle.min.css')}}"/>
    <link rel="stylesheet" href="{{url('fa/css/all.css')}}"/>
    <link rel="stylesheet" href="{{url('css/layouts/style.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/header.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/bottom-navigation.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/dialog.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/footer.css')}}"/>

    {{-- other styles --}}
    @yield('stylesheet')

    {{-- jquery --}}
    <script type="module" src="{{url('js/jquery-3.7.1.min.js')}}"></script>

</head>
<body>

    {{-- email verification alert --}}
    @if (auth()->check() && auth()->user()->email_verified_at === null)
        <div class="red-alert">
            {{__('layouts/app.alert_email_unverified')}} {{ (app()->getLocale() === 'ar') ? '،' : ','}}
            <form action="{{route('verification.send')}}" method="POST">
                @csrf
                <button>{{__('layouts/app.alert_send_verification')}}</button>
            </form>
        </div>
    @endif

    {{-- success alert --}}
    @if (session('success'))
        <div class="green-alert" role="alert">{{session('success')}}</div>
    @endif

    {{-- error alert --}}
    @if (session('error'))
        <div class="red-alert" role="alert">{{session('error')}}</div>
    @endif

    {{-- any other alerts --}}
    @yield('alert')

    {{-- header --}}
    <x-header :links="[__('layouts/app.page_home') => ['link' => route('browse.index') , 'class' => 'header-home'],
                        __('layouts/app.page_shop') => ['link' => route('browse.shop') , 'class' => 'header-shop'] ]"
                        :search="isset($_GET['search']) ? e($_GET['search']) : '' " role="user"/>

    {{-- bottom navigation --}}
    <x-bottom-navigation :links="[ ['link' => route('browse.index' ) , 'class' => 'fas fa-home bottom-navigation-home'],
                                    ['link' => route('browse.shop') , 'class' => 'fas fa-tags bottom-navigation-shop'], ]" />

    {{-- dialog forms --}}
    <x-dialog />

    {{-- page content --}}
    @yield('content')

    {{-- footer --}}
    <x-footer :ourLocations="['link' => 'https://maps.app.goo.gl/D4RvrvvKM76bufUE6', 'label' => __('layouts/app.hardcoded_location')]"
                :quickLinks="[__('layouts/app.page_home') => ['link' => route('browse.index' ) , 'icon' => 'fa-solid fa-house' ]
                            , __('layouts/app.page_shop') => ['link' => route('browse.shop') , 'icon' => 'fas fa-tags' ] ]"
                :moreLinks="[__('layouts/app.page_cart') => ['link' => route('browse.cart') , 'icon' => 'fas fa-shopping-cart' ]
                            , __('layouts/app.page_account') => ['link' => route('user.account') , 'icon' => 'fa-solid fa-user' ] ]"
                phone="+213540296200"/>

    {{-- scripts --}}
    <script type="module" src="{{url('package/swiper-bundle.min.js')}}"></script>
    <script type="module" src="{{url('js/components/header.js')}}"></script>
    <script type="module" src="{{url('js/components/dialog.js')}}"></script>

    {{-- other scripts --}}
    @yield('script')
</body>
</html>
