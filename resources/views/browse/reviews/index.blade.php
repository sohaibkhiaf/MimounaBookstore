@extends('layouts.app')

@section('title' , __('reviews/reviews-index.title_all_reviews', ['book_title' => $book->title]))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/reviews/reviews-index.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/review.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-details.css')}}"/>
@endsection

@section('content')

    <!-- ---------------------------------------- book section ----------------------------------------- -->

    <section class="details">

        <x-book-details :book="$book" />

    </section>

    <!-- ------------------------------------- reviews section ----------------------------------------- -->

    <section class="reviews">

        <h1 style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
            <span>{{__('reviews/reviews-index.header_all_reviews', ['book_title' => $book->title])}}</span>
        </h1>

        @foreach ($reviews as $review)
            <x-review :review="$review" :user="auth()->check() ? auth()->user() : null" />
        @endforeach

        <div class="more">
            <i class="fa-solid fa-house"></i>
            <a href="{{route('browse.book', ['book' => $book->id])}}"
                class="browse-reviews">
                {{__('reviews/reviews-index.link_return_book', ['book_title' => $book->title])}}
            </a>
            <br>

            <i class="fa-solid fa-plus"></i>
            <a href="{{route('reviews.create', ['book' => $book->id])}}"
                class="add-review">
                {{__('reviews/reviews-index.link_add_review', ['book_title' => $book->title])}}
            </a>
        </div>

        <div class="navigator-container">

            @if ($reviews->currentPage() > 1)
                <a href="{{$reviews->previousPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}" class=""></i></a>
            @else
                <a href="{{$reviews->url($reviews->currentPage())}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
            @endif

            @for ($i = 1; $i <= $reviews->lastPage(); $i++)
                @if ($reviews->currentPage() == $i)
                    <a href="{{$reviews->url($i)}}" class="active">{{$i}}</a>
                @else
                    <a href="{{$reviews->url($i)}}">{{$i}}</a>
                @endif
            @endfor

            @if ($reviews->currentPage() < $reviews->lastPage())
                <a href="{{$reviews->nextPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
            @else
                <a href="{{$reviews->url($reviews->currentPage())}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
            @endif

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/reviews/reviews-index.js')}}"></script>
    <script type="module" src="{{url('js/components/review.js')}}"></script>
    <script type="module" src="{{url('js/components/book-details.js')}}"></script>
@endsection
