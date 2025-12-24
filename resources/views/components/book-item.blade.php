<div class="swiper-slide book-item">

    @if ($book->likes_count > 0)
        <div class="like">
            <a class="fas fa-heart add-to-wishlist active" data-book-id="{{$book->id}}"></a>
        </div>
    @else
        <div class="like">
            <a class="fas fa-heart add-to-wishlist" data-book-id="{{$book->id}}"></a>
        </div>
    @endif

    <div class="image">
        <img class="book-image" data-book-id="{{$book->id}}" src="{{asset('uploads/'.$book->image_url) }}"
            alt="{{$book->title}}"/>
    </div>

    @if ($book->discount === 0)
        <div class="content">
            <h3>{{$book->title}}</h3>
            <div class="price">{{$book->price}}{{__('components/book-item.hardcoded_da')}}</div>
            <a class="add-to-cart" data-book-id="{{$book->id}}" data-book-title="{{$book->title}}"
                data-book-price="{{$book->price}}" data-book-quantity="{{$book->quantity}}"
                data-not-available="{{__('components/book-item.button_not_available')}}"
                data-add-to-cart="{{__('components/book-item.button_add_to_cart')}}"
                data-view-cart="{{__('components/book-item.button_view_cart')}}">
                {{__('components/book-item.button_add_to_cart')}}
            </a>
        </div>
    @else
        <div class="content">
            <h3>{{$book->title}}</h3>
            <div class="price">{{$book->discount}}{{__('components/book-item.hardcoded_da')}}
                <span>{{$book->price}}{{__('components/book-item.hardcoded_da')}}</span>
            </div>
            <a class="add-to-cart" data-book-id="{{$book->id}}" data-book-title="{{$book->title}}"
                data-book-price="{{$book->discount}}" data-book-quantity="{{$book->quantity}}"
                data-not-available="{{__('components/book-item.button_not_available')}}"
                data-add-to-cart="{{__('components/book-item.button_add_to_cart')}}"
                data-view-cart="{{__('components/book-item.button_view_cart')}}">
                {{__('components/book-item.button_add_to_cart')}}
            </a>
        </div>
    @endif

</div>
