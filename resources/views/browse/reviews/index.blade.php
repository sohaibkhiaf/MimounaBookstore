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
            <x-review :review="$review" :user="auth()->user()" />
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
            {{ $reviews->links() }}
        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/reviews/reviews-index.js')}}"></script>
    <script type="module" src="{{url('js/components/review.js')}}"></script>
    <script type="module" src="{{url('js/components/book-details.js')}}"></script>
@endsection
