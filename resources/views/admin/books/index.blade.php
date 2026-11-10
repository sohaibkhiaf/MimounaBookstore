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

                <a href="{{route('admin.books', ['search' => $search])}}" @class(['active' => empty($gid)])>
                    <i class="fa-solid fa-book-atlas"></i>
                    {{__('admin/books-index.tab_all_books')}}
                    <span>({{\App\Models\Book::count()}})</span>
                </a>

                @foreach ($genres as $genre)
                    <a href="{{route('admin.books', ['search' => $search, 'gid' => $genre->id])}}" @class(['active' => isset($gid) && $gid == $genre->id])>
                        <i class="{{$genre->fa_icon}}"></i>
                        {{$genre->name}}
                        <span>({{$genre->books_count ?? $genre->books->count()}})</span>
                    </a>
                @endforeach

                <h3>{{__('admin/books-index.header_actions')}}</h3>
                <a href="{{route('admin.books.create')}}"><i class="fas fa-plus"></i> {{__('admin/books-index.tab_add_book')}} <span></span></a>
                <a href="{{route('admin.genres.create')}}"><i class="fas fa-plus"></i> {{__('admin/books-index.tab_add_genre')}} <span></span></a>

                @isset($gid)
                    @php
                        $selectedGenre = $genres->firstWhere('id', $gid);
                    @endphp
                    @if ($selectedGenre)
                        <a class="edit-genre-button" href="{{route('admin.genres.edit', ['genre' => $gid])}}">
                            <i class="fas fa-pen"></i>
                            {{__('admin/books-index.tab_edit_genre')}} (`{{ $selectedGenre->name }}`)
                            <span></span>
                        </a>

                        <form class="delete-genre-form" data-genre-id="{{$gid}}" method="POST"
                            action="{{route('admin.genres.delete', ['genre' => $gid])}}">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="delete-genre-button" data-genre-id="{{$gid}}"
                                data-genre-name="{{ $selectedGenre->name }}">
                                <i class="fas fa-trash"></i>
                                {{__('admin/books-index.tab_delete_genre')}} (`{{ $selectedGenre->name }}`)
                                <span></span>
                            </a>
                        </form>
                    @endif
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

                @if ($books->isEmpty())
                    <div class="no-results">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        {{__('admin/books-index.message_no_results')}}
                    </div>
                @else
                    {{ $books->links() }}
                @endif

            </div>

        </main>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/admin/books-index.js')}}"></script>
    <script type="module" src="{{url('js/components/admin-book-item.js')}}"></script>
@endsection
