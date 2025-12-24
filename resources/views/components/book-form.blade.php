<div class="form-container">

    <form method="POST" action="{{$action === 'edit' ? route('admin.books.update', ['book' => $book->id])
        : route('admin.books.store')}}" enctype="multipart/form-data">
        @csrf
        @if ($action === 'edit')
            @method('PUT')
        @endif

        <h3>{{ $action === 'edit' ? __('components/book-form.header_edit').' `'.$book->title.'`' : __('components/book-form.header_add')}}</h3>

        <span>{{__('components/book-form.label_title')}}*</span>
        <input type="text" name="title" class="box" value="{{$action === 'edit' ? $book->title : ''}}"
            placeholder="{{__('components/book-form.placeholder_title')}}" maxlength="255" required/>
        @error('title')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_author')}}*</span>
        <input type="text" name="author" class="box" value="{{$action === 'edit' ? $book->author : ''}}"
            placeholder="{{__('components/book-form.placeholder_author')}}" maxlength="255" required/>
        @error('author')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_description')}}*</span>
        <textarea name="description" class="box" cols="30" rows="5" placeholder="{{__('components/book-form.placeholder_description')}}" required>{{$action === 'edit' ? $book->description : ''}}</textarea>
        @error('description')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_price')}}*</span>
        <input type="number" name="price" class="box" placeholder="{{__('components/book-form.placeholder_price')}}"
            value="{{$action === 'edit' ? $book->price : ''}}" required/>
        @error('price')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_discount')}}*</span>
        <input type="number" name="discount" class="box" placeholder="{{__('components/book-form.placeholder_discount')}}"
            value="{{$action === 'edit' ? $book->discount : ''}}" required/>
        @error('discount')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_quantity')}}*</span>
        <input type="number" name="quantity" class="box" placeholder="{{__('components/book-form.placeholder_quantity')}}"
            value="{{$action === 'edit' ? $book->quantity : ''}}" required/>
        @error('quantity')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_cover')}}*</span>
        <input type="file" name="image" class="box" {{$action === 'create' ? 'required' : ''}}>
        @error('image')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/book-form.label_genre')}}*</span>
        <select name="genre" required>
            <option value="">{{__('components/book-form.placeholder_genre')}}</option>
            @foreach ($genres as $genre)
                @if ( $action === 'edit' && $genre->id === $book->genre->id)
                    <option value="{{$genre->id}}" selected>{{(app()->getLocale() === 'ar') ? $genre->ar_name : ( app()->getLocale() === 'fr' ? $genre->fr_name : $genre->en_name )}}</option>
                @else
                    <option value="{{$genre->id}}">{{(app()->getLocale() === 'ar') ? $genre->ar_name : ( app()->getLocale() === 'fr' ? $genre->fr_name : $genre->en_name )}}</option>
                @endif
            @endforeach
        </select>
        @error('genre')
            <div class="error">{{$message}}</div>
        @enderror

        <div class="bestseller">
            <input style="{{(app()->getLocale() === 'ar') ? 'margin-left: .5rem;' : 'margin-right: .5rem;' }}" type="checkbox"
                name="bestseller" {{$book->bestseller ? 'checked' : ''}}/>
            <label for="bestseller">{{__('components/book-form.label_bestseller')}}</label>
        </div>
        @error('bestseller')
            <div class="error">{{$message}}</div>
        @enderror

        <div class="bookshelf">
            <input style="{{(app()->getLocale() === 'ar') ? 'margin-left: .5rem;' : 'margin-right: .5rem;' }}" type="checkbox"
                name="bookshelf" {{$book->bookshelf ? 'checked' : ''}}/>
            <label for="bookshelf">{{__('components/book-form.label_bookshelf')}}</label>
        </div>
        @error('bookshelf')
            <div class="error">{{$message}}</div>
        @enderror

        @if ($action === 'edit')
            <div class="buttons-container">
                <a href="{{route('admin.books')}}" class="cancel-button">
                    {{__('components/book-form.button_cancel')}}
                </a>
                <input type="submit" value="{{__('components/book-form.button_edit_book')}}" class="edit-button" name="edit-book"/>
            </div>
        @else
            <input type="submit" value="{{__('components/book-form.button_create_book')}}" class="create-button" name="create-book"/>
        @endif
    </form>

</div>
