@extends('layouts.app')

@section('title' , __('user/wishlist.title_wishlist'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/user/wishlist.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-item.css')}}"/>
@endsection

@section('content')

    <!------------------------------------------------------ wishlist --------------------------------------------->

    <section class="wishlist-books">

        <div class="wishlist-container">

            @foreach ($books as $book)

                <x-book-item :$book />

            @endforeach

        </div>

    </section>

    <!------------------------------------------------------ navigator --------------------------------------------->

    <section class="navigator">

        <div class="navigator-container">

            @if ($books->count() == 0)
                <div class="no-results">
                <i class="fa-solid fa-circle-exclamation"></i><br>
                    {{__('user/wishlist.message_no_items')}}
                </div>
            @else

                @if ($books->currentPage() > 1)
                    <a href="{{$books->previousPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                @else
                    <a href="{{$books->url($books->currentPage())}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                @endif

                @for ($i = 1; $i <= $books->lastPage(); $i++)
                    @if ($books->currentPage() == $i)
                        <a href="{{$books->url($i)}}" class="active">{{$i}}</a>
                    @else
                        <a href="{{$books->url($i)}}">{{$i}}</a>
                    @endif
                @endfor

                @if ($books->currentPage() < $books->lastPage())
                    <a href="{{$books->nextPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                @else
                    <a href="{{$books->url($books->currentPage())}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                @endif

            @endif

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/user/wishlist.js')}}"></script>
    <script type="module" src="{{url('js/components/book-item.js')}}"></script>
@endsection
