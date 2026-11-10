<div class="swiper-slide admin-book-item">

    <div class="actions">
        <a href="{{route('admin.books.edit' , ['book' => $book->id])}}"
            class="fas fa-pen action-edit" data-book-id="{{$book->id}}"
            title="{{__('components/admin-book-item.title_edit')}}"></a>

        <form class="delete-book-form" data-book-id="{{$book->id}}" method="POST"
            action="{{route('admin.books.delete' , ['book' => $book->id])}}">
            @csrf
            @method('DELETE')
            <a class="fas fa-trash action-delete" data-book-id="{{$book->id}}" data-book-title="{{$book->title}}"
                title="{{__('components/admin-book-item.title_delete')}}"></a>
        </form>

        @if ($book->quantity === 0)
            <i class="fa-solid fa-circle-exclamation" title="{{__('components/admin-book-item.title_out_of_stock')}}"></i>
        @endif
    </div>

    <div class="image">
        <img class="book-image" data-book-id="{{$book->id}}" src="{{asset('uploads/'.$book->image_url)}}" alt="{{$book->title}}">
    </div>

    @if ($book->discount === 0)
        <div class="content">
            <h3>{{$book->title}}</h3>
            <div class="price">{{$book->price}}{{__('components/admin-book-item.hardcoded_da')}}</div>
        </div>
    @else
        <div class="content">
            <h3>{{$book->title}}</h3>
            <div class="price">{{$book->discount}}{{__('components/admin-book-item.hardcoded_da')}}
                <span>{{$book->price}}{{__('components/admin-book-item.hardcoded_da')}}</span>
            </div>
        </div>
    @endif

</div>
