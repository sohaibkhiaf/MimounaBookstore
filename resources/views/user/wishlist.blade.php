@extends('layouts.app')

@section('title' , __('user/wishlist.title_wishlist'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/user/wishlist.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-item.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/mini-cart.css')}}"/>
@endsection

@section('content')

    <x-mini-cart />

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

            @if ($books->isEmpty())
                <div class="no-results">
                    <i class="fa-solid fa-circle-exclamation"></i><br>
                    {{__('user/wishlist.message_no_items')}}
                </div>
            @else
                {{ $books->links() }}
            @endif

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/user/wishlist.js')}}"></script>
    <script type="module" src="{{url('js/components/book-item.js')}}"></script>
    <script type="module" src="{{url('js/components/mini-cart.js')}}"></script>
@endsection
