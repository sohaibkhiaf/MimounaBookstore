@extends('layouts.app-admin')

@section('title' , __('admin/books-index.title_books_genres'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/books-index.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/admin-book-item.css')}}"/>
@endsection

@section('content')

    <!-- -------------------------------------------- books section ------------------------------------------------ -->

    <section class="books">

        <aside class="aside">

            <div class="aside-container">

                <h3>{{__('admin/books-index.header_genres')}}</h3>

                @isset($gid)
                    <a href="{{route('admin.books' , ['search' => $search])}}"><i class="fa-solid fa-book-atlas"></i> {{__('admin/books-index.tab_all_books')}} <span>({{\App\Models\Book::all()->count()}})</span></a>
                @else
                    <a href="{{route('admin.books' , ['search' => $search])}}" class="active"><i class="fa-solid fa-book-atlas"></i> {{__('admin/books-index.tab_all_books')}} <span>({{\App\Models\Book::all()->count()}})</span></a>
                @endisset

                @foreach ($genres as $genre)

                    @isset($gid)

                        @if ($gid == $genre->id)
                            <a href="{{route('admin.books' , ['search' => $search, 'gid' => $genre->id])}}" class="active">
                                <i class="{{$genre->fa_icon}}"></i>
                                @if (app()->getLocale() === 'ar')
                                    {{ $genre->ar_name }}
                                @elseif (app()->getLocale() === 'fr')
                                    {{ $genre->fr_name }}
                                @else
                                    {{ $genre->en_name }}
                                @endif
                                <span>({{$genre->books->count()}})</span>
                            </a>
                        @else
                            <a href="{{route('admin.books' , ['search' => $search, 'gid' => $genre->id])}}">
                                <i class="{{$genre->fa_icon}}"></i>
                                @if (app()->getLocale() === 'ar')
                                    {{ $genre->ar_name }}
                                @elseif (app()->getLocale() === 'fr')
                                    {{ $genre->fr_name }}
                                @else
                                    {{ $genre->en_name }}
                                @endif
                                <span>({{$genre->books->count()}})</span>
                            </a>

                        @endif

                    @else
                        <a href="{{route('admin.books' , ['search' => $search, 'gid' => $genre->id])}}">
                            <i class="{{$genre->fa_icon}}"></i>
                            @if (app()->getLocale() === 'ar')
                                {{ $genre->ar_name }}
                            @elseif (app()->getLocale() === 'fr')
                                {{ $genre->fr_name }}
                            @else
                                {{ $genre->en_name }}
                            @endif
                            <span>({{$genre->books->count()}})</span></a>

                    @endisset

                @endforeach

                <h3>{{__('admin/books-index.header_actions')}}</h3>
                <a href="{{route('admin.books.create')}}"><i class="fas fa-plus"></i> {{__('admin/books-index.tab_add_book')}} <span></span></a>
                <a href="{{route('admin.genres.create')}}"><i class="fas fa-plus"></i> {{__('admin/books-index.tab_add_genre')}} <span></span></a>

                @isset($gid)
                    <a class="edit-genre-button" href="{{route('admin.genres.edit' , ['genre' => $gid])}}">
                        <i class="fas fa-pen"></i>
                        @if (app()->getLocale() === 'ar')
                            {{__('admin/books-index.tab_edit_genre')}} (`{{ $genres->where('id' , '=' , $gid)->first()->ar_name }}`)
                        @elseif (app()->getLocale() === 'fr')
                            {{__('admin/books-index.tab_edit_genre')}} (`{{ $genres->where('id' , '=' , $gid)->first()->fr_name }}`)
                        @else
                            {{__('admin/books-index.tab_edit_genre')}} (`{{ $genres->where('id' , '=' , $gid)->first()->en_name }}`)
                        @endif
                        <span></span>
                    </a>

                    <form class="delete-genre-form" data-genre-id="{{$gid}}"  method="POST"
                        action="{{route('admin.genres.delete' , ['genre' => $gid])}}" >
                        @csrf
                        @method('DELETE')
                        <a href="#" class="delete-genre-button" data-genre-id="{{$gid}}"
                            data-genre-name="{{ (app()->getLocale() === 'ar') ? $genres->where('id' , '=' , $gid)->first()->ar_name : ( (app()->getLocale() === 'fr') ? $genres->where('id' , '=' , $gid)->first()->fr_name : $genres->where('id' , '=' , $gid)->first()->en_name ) }}">
                            <i class="fas fa-trash"></i>

                            @if (app()->getLocale() === 'ar')
                                {{__('admin/books-index.tab_delete_genre')}} (`{{ $genres->where('id' , '=' , $gid)->first()->ar_name }}`)
                            @elseif (app()->getLocale() === 'fr')
                                {{__('admin/books-index.tab_delete_genre')}} (`{{ $genres->where('id' , '=' , $gid)->first()->fr_name }}`)
                            @else
                                {{__('admin/books-index.tab_delete_genre')}} (`{{ $genres->where('id' , '=' , $gid)->first()->en_name }}`)
                            @endif
                            <span></span>
                        </a>
                    </form>
                @endisset

            </div>

        </aside>

        <main class="main">

            <div class="book-container">

                @foreach ($books as $book)
                    <x-admin-book-item :$book />
                @endforeach

            </div>

            <!-- --------------------------------------- navigator ------------------------------------------------ -->

            <div class="navigator-container">

                @if ($books->count() == 0)
                    <div class="no-results">
                    <i class="fa-solid fa-circle-exclamation"></i><br>
                        {{__('admin/books-index.message_no_results')}}
                    </div>
                @else

                    @if ($books->currentPage() > 1)
                        <a href="{{$books->previousPageUrl().'&search='.$search.'&gid='.$gid}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
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
    <script type="module" src="{{url('js/admin/books-index.js')}}"></script>
    <script type="module" src="{{url('js/components/admin-book-item.js')}}"></script>
@endsection
