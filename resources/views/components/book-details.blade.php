@php
    $effectivePrice = $book->discount === 0 ? $book->price : $book->discount;
    $totalLikes = $book->total_likes_count ?? $book->likes()->count();
@endphp

<div class="book-container">

    <div class="book-picture">

        <div class="book-image-container">
            <img src="{{asset('uploads/'.$book->image_url)}}" alt="{{$book->title}}"/>

            <div style="{{app()->getLocale() === 'ar' ? 'right: 0;' : 'left: 0;'}}" class="book-like">
                <a @class(['fas fa-heart add-book-to-wishlist', 'active' => $book->likes_count > 0]) data-book-id="{{$book->id}}"></a>
                <p class="number-of-likes">{{$totalLikes}}</p>
            </div>
        </div>

    </div>

    <div class="book-details">

        <a href="{{route('browse.shop', ['gid' => $book->genre->id])}}" class="book-genre">{{$book->genre->name}}</a>
        <h3 class="book-title">{{$book->title}}</h3>

        @if ($book->discount === 0)
            <div class="book-price">{{$book->price}}{{__('components/book-details.hardcoded_da')}}</div>
        @else
            <div class="book-price">{{$book->discount}}{{__('components/book-details.hardcoded_da')}} <span class="book-discount">{{$book->price}}{{__('components/book-details.hardcoded_da')}}</span></div>
        @endif

        @if ($book->quantity > 0)
            <p class="book-availability" style="color: green; font-weight: bold">{{__('components/book-details.status_available')}}</p>

            <div>
                <a class="add-to-cart" data-book-id="{{$book->id}}" data-book-title="{{$book->title}}"
                    data-book-price="{{$effectivePrice}}" data-add-to-cart="{{__('components/book-details.button_add_to_cart')}}"
                    data-view-cart="{{__('components/book-details.button_view_cart')}}">{{__('components/book-details.button_add_to_cart')}}</a>

                <select style="{{app()->getLocale() === 'ar' ? 'margin-right: 1rem;' : 'margin-left: 1rem;'}}" class="book-quantity">
                    @for ($q = 1; $q <= 5; $q++)
                        <option value="{{$q}}" @selected($q === 1)>{{$q}}</option>
                    @endfor
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
