@extends('layouts.app')

@section('title' , __('browse/shop.title_shop'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/shop.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-item.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/mini-cart.css')}}"/>
@endsection

@section('content')

    <x-mini-cart />

    <!-- -------------------------------------------- shop section ------------------------------------------------ -->

    <section class="shop">

        <aside class="aside">

            <div class="aside-container">

                <h3>{{__('browse/shop.header_genres')}}</h3>

                <a href="{{route('browse.shop', ['search' => $search])}}" @class(['active' => empty($gid)])>
                    <i class="fa-solid fa-book-atlas"></i>
                    {{__('browse/shop.tab_all_books')}}
                    <span>({{\App\Models\Book::count()}})</span>
                </a>

                @foreach ($genres as $genre)
                    <a href="{{route('browse.shop', ['search' => $search, 'gid' => $genre->id])}}" @class(['active' => isset($gid) && $gid == $genre->id])>
                        <i class="{{$genre->fa_icon}}"></i>
                        {{$genre->name}}
                        <span>({{$genre->books_count ?? $genre->books->count()}})</span>
                    </a>
                @endforeach

            </div>

        </aside>

        <main class="main">

            <div class="book-container">

                @foreach ($books as $book)
                    <x-book-item :$book />
                @endforeach

            </div>

            <!-- --------------------------------------- navigator ------------------------------------------------ -->

            <div class="navigator-container">

                @if ($books->isEmpty())
                    <div class="no-results">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        {{__('browse/shop.message_no_results')}}
                    </div>
                @else
                    {{ $books->links() }}
                @endif

            </div>

        </main>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/shop.js')}}"></script>
    <script type="module" src="{{url('js/components/book-item.js')}}"></script>
    <script type="module" src="{{url('js/components/mini-cart.js')}}"></script>
@endsection
