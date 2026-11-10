<div class="form-container">

    <form method="POST" action="{{$action === 'edit' ? route('reviews.update', ['book' => $review->book->id , 'review' => $review->id])
        : route('reviews.store' , ['book' => $book->id])}}">
        @csrf
        @if ($action === 'edit')
            @method('PUT')
        @endif

        <h3>{{$action === 'edit' ? __('components/review-form.header_edit_review', ['book_title' => $review->book->title]) : __('components/review-form.header_create_review', ['book_title' => $book->title]) }}</h3>

        <span>{{__('components/review-form.label_review')}}*</span>
        <textarea name="review" class="box" cols="30" rows="5" placeholder="{{__('components/review-form.placeholder_review', ['book_title' => $book->title ?? $review->book->title])}}" required>{{$action === 'edit' ? $review->review : ''}}</textarea>
        @error('review')
            <div class="error">{{$message}}</div>
        @enderror

        @if ($action === 'edit')
            <div class="buttons-container">
                <a href="{{route('browse.book' , ['book'=> $review->book->id])}}" class="cancel-button">
                    {{__('components/review-form.button_cancel')}}
                </a>
                <input type="submit" value="{{__('components/review-form.button_edit_review')}}" class="edit-button"/>
            </div>
        @else
            <input type="submit" value="{{__('components/review-form.button_add_review')}}" class="create-button"/>
        @endif

    </form>

</div>
