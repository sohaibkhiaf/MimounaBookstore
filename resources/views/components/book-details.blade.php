<div class="book-container">

    <div class="book-picture">

        <div class="book-image-container">
            <img src="{{asset('uploads/'.$book->image_url)}}" alt="{{$book->title}}"/>

            @if ($book->likes_count > 0)
                <div style="{{(app()->getLocale() === 'ar') ? 'right: 0;' : 'left: 0;'}}" class="book-like">
                    <a class="fas fa-heart add-book-to-wishlist active" data-book-id="{{$book->id}}"></a>
                    <p class="number-of-likes">{{$book->likes->count()}}</p>
                </div>
            @else
                <div style="{{(app()->getLocale() === 'ar') ? 'right: 0;' : 'left: 0;'}}" class="book-like">
                    <a class="fas fa-heart add-book-to-wishlist" data-book-id="{{$book->id}}"></a>
                    <p class="number-of-likes">{{$book->likes->count()}}</p>
                </div>
            @endif
        </div>

    </div>

    <div class="book-details">

        <a href="{{route('browse.shop' , ['gid' => $book->genre->id])}}" class="book-genre">{{ (app()->getLocale() === 'ar') ? $book->genre->ar_name : ( app()->getLocale() === 'fr' ? $book->genre->fr_name : $book->genre->en_name ) }}</a>
        <h3 class="book-title">{{$book->title}}</h3>

        @if ($book->discount === 0)
            <div class="book-price">{{$book->price}}{{__('components/book-details.hardcoded_da')}}</div>
        @else
            <div class="book-price">{{$book->discount}}{{__('components/book-details.hardcoded_da')}} <span class="book-discount">{{$book->price}}{{__('components/book-details.hardcoded_da')}}</span></div>
        @endif

        @if ($book->quantity > 0)
            <p class="book-availability" style="color: green; font-weight: bold">{{__('components/book-details.status_available')}}</p>

            <div>

                @if ($book->discount === 0)
                    <a class="add-to-cart" data-book-id="{{$book->id}}" data-book-title="{{$book->title}}"
                        data-book-price="{{$book->price}}" data-add-to-cart="{{__('components/book-details.button_add_to_cart')}}"
                        data-view-cart="{{__('components/book-details.button_view_cart')}}"> {{__('components/book-details.button_add_to_cart')}} </a>
                @else
                    <a class="add-to-cart" data-book-id="{{$book->id}}" data-book-title="{{$book->title}}"
                        data-book-price="{{$book->discount}}" data-add-to-cart="{{__('components/book-details.button_add_to_cart')}}"
                        data-view-cart="{{__('components/book-details.button_view_cart')}}"> {{__('components/book-details.button_add_to_cart')}} </a>
                @endif

                <select style="{{(app()->getLocale() === 'ar') ? 'margin-right: 1rem;' : 'margin-left: 1rem;'}}" class="book-quantity">
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

        @else
            <p class="book-availability" style="color: red; font-weight: bold">{{__('components/book-details.status_unavailable')}}</p>

            <div>
                <a style="display: none;" class="add-to-cart" data-book-id="{{$book->id}}"
                    data-book-title="{{$book->title}}" data-book-price="{{$book->price}}"
                    data-add-to-cart="{{__('components/book-details.button_add_to_cart')}}" data-view-cart="{{__('components/book-details.button_view_cart')}}">
                    {{__('components/book-details.button_add_to_cart')}}
                </a>
            </div>

        @endif

        <p class="book-author">{{$book->author}}</p>
        <p class="book-description">{{$book->description}}</p>

    </div>

</div>
