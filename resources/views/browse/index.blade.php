@extends('layouts.app')

@section('title' , __('browse/home.title_index'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/home.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-item.css')}}"/>
@endsection

@section('content')

    <!-- ------------------------------------------------- home --------------------------------------------------- -->

    <section class="home">

        <div class="row">

            <div class="content">

                <h3>{{__('browse/home.header_welcome')}}</h3>
                <p>{{__('browse/home.paragraph_welcome')}}</p>
                <a href="{{route('browse.shop')}}" class="btn">{{__('browse/home.button_shop')}}</a>

            </div>

            <div class="swiper bookshelf-slider">

                <div class="swiper-wrapper">

                    @foreach ($bookshelf_books as $book)
                        <a href="{{route('browse.book' , ['book' => $book])}}" class="swiper-slide">
                            <img src="{{asset('uploads/'.$book->image_url)}}" alt="{{$book->title}}"/>
                        </a>
                    @endforeach

                </div>

                <img src="{{url('images/bookshelf.png')}}" class="bookshelf" alt="{{__('browse/home.alternative_bookshelf')}}"/>

            </div>

        </div>

    </section>

    <!-- -------------------------------------------------- icons ----------------------------------------------- -->

    <section class="icons-container">

        <div class="icons">
            <i class="fa-solid fa-truck"></i>
            <div class="content">
                <h3>{{__('browse/home.icon_01')}}</h3>
                <p>{{__('browse/home.icon_01_desc')}}</p>
            </div>
        </div>

        <div class="icons">
            <i class="fa-solid fa-wallet"></i>
            <div class="content">
                <h3>{{__('browse/home.icon_02')}}</h3>
                <p>{{__('browse/home.icon_02_desc')}}</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-redo-alt"></i>
            <div class="content">
                <h3>{{__('browse/home.icon_03')}}</h3>
                <p>{{__('browse/home.icon_03_desc')}}</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-headset"></i>
            <div class="content">
                <h3>{{__('browse/home.icon_04')}}</h3>
                <p>{{__('browse/home.icon_04_desc')}}</p>
            </div>
        </div>

    </section>

    <!-- ------------------------------------------------- bestsellers -------------------------------------------- -->

    <section class="bestsellers">

        <h1 style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
            <span>{{__('browse/home.header_bestsellers')}}</span>
        </h1>

        <div class="swiper book-slider">

            <div class="swiper-wrapper">

                @foreach ($bestsellers as $book)
                    <x-book-item :$book />
                @endforeach

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

    <!-- ------------------------------------------------- novels -------------------------------------------- -->

    <section class="novels">

        <h1 style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
            <span>{{__('browse/home.header_novels')}}</span>
        </h1>

        <div class="swiper book-slider">

            <div class="swiper-wrapper">

                @foreach ($novels as $book)
                    <x-book-item :$book />
                @endforeach

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

    <!-- ------------------------------------------------- newly added -------------------------------------------- -->

    <section class="newly-added">

        <h1 style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
            <span>{{__('browse/home.header_newly_added')}}</span>
        </h1>

        <div class="swiper book-slider">

            <div class="swiper-wrapper">

                @foreach ($newly_added as $book)
                    <x-book-item :$book />
                @endforeach

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/home.js')}}"></script>
    <script type="module" src="{{url('js/components/book-item.js')}}"></script>
@endsection

