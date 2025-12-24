@extends('layouts.app-admin')

@section('title' , 'Client Reviews')

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/reviews-index.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/admin-review.css')}}"/>
@endsection

@section('content')

    <!-- -------------------------------------------- reviews section ------------------------------------------------ -->

    <section class="reviews">

        <div class="content-container">

            <div class="reviews-container">

                <h3>{{ __('admin/reviews-index.header_reviews_management') }}</h3>

                @if ($reviews->count() > 0)

                    @foreach ($reviews as $review)
                        <x-admin-review :review="$review" />
                    @endforeach

                    <div class="navigator-container">

                        @if ($reviews->currentPage() > 1)
                            <a href="{{$reviews->previousPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
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

                @else

                    <div class="no-reviews-found">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        No Reviews Found
                        {{ __('admin/reviews-index.message_no_results') }}
                    </div>
                @endif

            </div>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/components/admin-review.js')}}"></script>
@endsection
