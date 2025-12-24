@extends('layouts.app')

@section('title' , $book->title)

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/book.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-item.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/review.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-details.css')}}"/>
@endsection

@section('content')

    <!-- ------------------------------------------book details section ------------------------------------- -->

    <section class="details">

        <x-book-details :book="$book" />

    </section>

    <!-- ------------------------------------------ reviews section ------------------------------------------ -->

    <section class="reviews">

        <h1 style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
            <span>{{__('browse/book.header_reviews')}}</span>
        </h1>

        <div class="top-reviews">

            @if ($reviews->count() > 0 || $admin_reviews->count() > 0)
                @foreach ($admin_reviews as $review)
                    <x-review :review="$review" :user="auth()->check() ? auth()->user() : null" />
                @endforeach

                @foreach ($reviews as $review)
                    @if ($review->user->role === 0)
                        <x-review :review="$review" :user="auth()->check() ? auth()->user() : null" />
                    @endif
                @endforeach
            @else
                <div class="no-reviews">
                    <i class="fa-solid fa-circle-exclamation"></i><br>
                    {{__('browse/book.message_no_reviews')}}
                </div>
            @endif

        </div>

        <div class="more">
            @if ($reviews->count() > 0)
                <i class="fa-solid fa-list"></i>
                <a href="{{route('reviews.index', ['book' => $book->id])}}"
                    class="browse-reviews">
                    {{__('browse/book.link_browse_reviews', ['book_title' => $book->title])}}
                </a>
                <br>
            @endif
            <i class="fa-solid fa-plus"></i>
            <a href="{{route('reviews.create', ['book' => $book->id])}}"
                class="add-review">
                {{__('browse/book.link_add_review', ['book_title' => $book->title])}}
            </a>
        </div>

    </section>

    <!-- ------------------------------------------ related section ------------------------------------------ -->

    <section class="related">

        <h1 style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
            <span>{{__('browse/book.header_related_books')}}</span>
        </h1>

        <div class="swiper related-slider">

            <div class="swiper-wrapper">

                @foreach ($related_books as $book)
                    <x-book-item :book="$book" />
                @endforeach

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>
@endsection

@section('script')
    <script type="module" src="{{url('js/browse/book.js')}}"></script>
    <script type="module" src="{{url('js/components/book-item.js')}}"></script>
    <script type="module" src="{{url('js/components/review.js')}}"></script>
    <script type="module" src="{{url('js/components/book-details.js')}}"></script>
@endsection
