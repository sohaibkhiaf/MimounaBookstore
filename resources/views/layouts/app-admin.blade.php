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
    <x-header :links="[__('layouts/app-admin.page_orders') => ['link' => route('admin.orders') , 'class' => 'header-orders'],
                        __('layouts/app-admin.page_books_genres') => ['link' => route('admin.books') , 'class' => 'header-books'],
                        __('layouts/app-admin.page_regions_shipping') => ['link' => route('admin.regions') , 'class' => 'header-regions'],
                        __('layouts/app-admin.page_users') => ['link' => route('admin.users') , 'class' => 'header-users'],
                        __('layouts/app-admin.page_reviews') => ['link' => route('admin.reviews' ) , 'class' => 'header-reviews'] ]"
                        :search="isset($_GET['search']) ? e($_GET['search']) : '' " role="admin"/>

    {{-- bottom navigation --}}
    <x-bottom-navigation :links="[ ['link' => route('admin.orders') , 'class' => 'fas fa-box bottom-navigation-orders'],
                                    ['link' => route('admin.books') , 'class' => 'fa-solid fa-book bottom-navigation-books'],
                                    ['link' => route('admin.regions') , 'class' => 'fas fa-truck-fast bottom-navigation-regions'],
                                    ['link' => route('admin.users') , 'class' => 'fa-solid fa-user bottom-navigation-users'],
                                    ['link' => route('admin.reviews') , 'class' => 'fa-solid fa-comment bottom-navigation-reviews'] ]" />

    {{-- dialog forms --}}
    <x-dialog />

    {{-- page content --}}
    @yield('content')

    {{-- footer --}}
    <x-footer :ourLocations="['link' => 'https://maps.app.goo.gl/MnWEEN7KDvEGftri9', 'label' => __('layouts/app-admin.hardcoded_location')]"
        :quickLinks="[__('layouts/app-admin.page_home') => ['link' => route('browse.index') , 'icon' => 'fa-solid fa-house' ]
                    , __('layouts/app-admin.page_shop') => ['link' => route('browse.shop') , 'icon' => 'fas fa-tags' ] ]"
        :moreLinks="[__('layouts/app-admin.page_cart') => ['link' => route('browse.cart') , 'icon' => 'fas fa-shopping-cart' ]
                    , __('layouts/app-admin.page_account') => [ 'link' => route('user.account') , 'icon' => 'fa-solid fa-user' ] ]"
        phone="+213540296200"/>

    {{-- scripts --}}
    <script type="module" src="{{url('package/swiper-bundle.min.js')}}"></script>
    <script type="module" src="{{url('js/components/header.js')}}"></script>
    <script type="module" src="{{url('js/components/dialog.js')}}"></script>

    {{-- other scripts --}}
    @yield('script')
</body>
</html>
