<header class="header">

    <div class="header-1">

        <img class="navigation-logo" src="{{url('images/logo.jpg')}}" alt="{{__('components/header.alternative_logo')}}"
            title="{{__('components/header.title_home')}}"/>

        <form class="search-form" method="GET"
            action="{{$role === 'user' ? route('browse.shop') : route('admin.books')}}">

            @isset($search)
                <input type="text" name="search" value="{{$search}}" placeholder="{{__('components/header.placeholder_search')}}" class="search-box"/>
                <label for="search-box" class="fas fa-search search-button"></label>
            @else
                <input type="text" name="search" placeholder="{{__('components/header.placeholder_search')}}" class="search-box"/>
                <label for="search-box" class="fas fa-search search-button"></label>
            @endisset

        </form>

        <div class="icons">

            <div class="fas fa-search search-icon"></div>

            @if (auth()->check())
                @if ($role === 'user')
                    <a href="{{route('user.wishlist')}}"
                        class="fas fa-heart wishlist-icon" title="{{__('components/header.title_wishlist')}}"></a>
                    <a href="{{route('browse.cart')}}"
                        class="fas fa-shopping-cart cart-icon" title="{{__('components/header.title_cart')}}">
                    </a>
                @endif
                <a class="fa-solid fa-earth-europe language-icon" title="{{__('components/header.title_language')}}"></a>
                <div class="fas fa-user login-icon active" title="{{__('components/header.title_account')}}"></div>

            @else
                <a class="fas fa-heart wishlist-icon" title="{{__('components/header.title_wishlist')}}"></a>
                <a href="{{route('browse.cart')}}"
                    class="fas fa-shopping-cart cart-icon" title="{{__('components/header.title_cart')}}">
                </a>
                <a class="fa-solid fa-earth-europe language-icon" title="{{__('components/header.title_language')}}"></a>
                <div class="fas fa-user login-icon" title="{{__('components/header.title_login')}}"></div>
            @endif

        </div>

    </div>

    <div class="header-2">
        <nav class="navigation-bar">
            @foreach ($links as $label => $data)
                <a href="{{$data['link']}}" class="{{$data['class']}}">{{ucfirst($label)}}</a>
            @endforeach
        </nav>
    </div>

</header>
