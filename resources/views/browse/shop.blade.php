@extends('layouts.app')

@section('title' , __('browse/shop.title_shop'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/shop.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-item.css')}}"/>
@endsection

@section('content')

    <!-- -------------------------------------------- shop section ------------------------------------------------ -->

    <section class="shop">

        <aside class="aside">

            <div class="aside-container">

                <h3>{{__('browse/shop.header_genres')}}</h3>

                @isset($gid)
                    <a href="{{route('browse.shop' , ['search' => $search])}}"><i class="fa-solid fa-book-atlas"></i> {{__('browse/shop.tab_all_books')}} <span>({{\App\Models\Book::all()->count()}})</span></a>
                @else
                    <a href="{{route('browse.shop' , ['search' => $search])}}" class="active"><i class="fa-solid fa-book-atlas"></i> {{__('browse/shop.tab_all_books')}} <span>({{\App\Models\Book::all()->count()}})</span></a>
                @endisset

                @foreach ($genres as $genre)

                    @isset($gid)

                        @if ($gid == $genre->id)
                            <a href="{{route('browse.shop' , ['search' => $search, 'gid' => $genre->id])}}"
                                class="active"><i class="{{$genre->fa_icon}}"></i>
                                {{(app()->getLocale() === 'ar') ? $genre->ar_name : ( app()->getLocale() === 'fr' ? $genre->fr_name : $genre->en_name ) }}
                                <span>({{$genre->books->count()}})</span></a>
                        @else
                            <a href="{{route('browse.shop' , ['search' => $search, 'gid' => $genre->id])}}">
                                <i class="{{$genre->fa_icon}}"></i>
                                {{(app()->getLocale() === 'ar') ? $genre->ar_name : ( app()->getLocale() === 'fr' ? $genre->fr_name : $genre->en_name ) }}
                                <span>({{$genre->books->count()}})</span></a>
                        @endif

                    @else
                        <a href="{{route('browse.shop' , ['search' => $search, 'gid' => $genre->id])}}">
                            <i class="{{$genre->fa_icon}}"></i>
                            {{(app()->getLocale() === 'ar') ? $genre->ar_name : ( app()->getLocale() === 'fr' ? $genre->fr_name : $genre->en_name ) }}
                            <span>({{$genre->books->count()}})</span></a>
                    @endisset

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

                @if ($books->count() == 0)
                    <div class="no-results">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        {{__('browse/shop.message_no_results')}}
                    </div>
                @else

                    @if ($books->currentPage() > 1)
                        <a href="{{$books->previousPageUrl().'&search='.$search.'&gid='.$gid}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}" class=""></i></a>
                    @else
                        <a href="{{$books->url($books->currentPage()).'&search='.$search.'&gid='.$gid}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                    @endif

                    @for ($i = 1; $i <= $books->lastPage(); $i++)
                        @if ($books->currentPage() == $i)
                            <a href="{{$books->url($i).'&search='.$search.'&gid='.$gid}}" class="active">{{$i}}</a>
                        @else
                            <a href="{{$books->url($i).'&search='.$search.'&gid='.$gid}}">{{$i}}</a>
                        @endif
                    @endfor

                    @if ($books->currentPage() < $books->lastPage())
                        <a href="{{$books->nextPageUrl().'&search='.$search.'&gid='.$gid}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                    @else
                        <a href="{{$books->url($books->currentPage()).'&search='.$search.'&gid='.$gid}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                    @endif

                @endif

            </div>

        </main>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/shop.js')}}"></script>
    <script type="module" src="{{url('js/components/book-item.js')}}"></script>
@endsection
