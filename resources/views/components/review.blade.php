<div class="review-container">

    <div class="top">

        <div class="name">
            {{$review->user->name}} <span>{{ $review->edited ? __('components/review.hardcoded_edited') : '' }}</span>
            @if ($review->user->role == 1)
                <i title="{{__('components/review.title_admin_review')}}" class="fa-solid fa-user-tie"></i>
            @endif
        </div>

        <div style="{{app()->getLocale() === 'ar' ? 'margin-right: auto;' : 'margin-left: auto;'}}" class="user-actions">

            @if (isset($user) && $user->id === $review->user->id)
                <a href="{{route('reviews.edit', ['book' => $review->book->id, 'review' => $review->id])}}"
                    class="fas fa-pen action-edit" title="{{__('components/review.title_edit_review')}}"></a>
                <form action="{{route('reviews.delete', ['book' => $review->book->id, 'review' => $review->id])}}"
                    method="POST" class="delete-review-form" data-review-id="{{$review->id}}">
                    @csrf
                    @method('DELETE')
                    <a href="#" data-review-id="{{$review->id}}" class="fas fa-trash action-delete" title="{{__('components/review.title_delete_review')}}"></a>
                </form>
            @endif

            @if (auth()->check() && auth()->user()->role == 1 && $review->user->role !== 1)
                <div class="admin-actions">
                    @if ($review->user->banned)
                        <form action="{{route('admin.unban.user', ['user' => $review->user->id])}}" method="POST"
                            data-user-id="{{$review->user->id}}" class="unban-user-form">
                            @csrf
                            @method('PUT')
                            <a href="#" class="fa-solid fa-ban unban-user active" data-user-id="{{$review->user->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/review.title_user_banned')}}"></a>
                        </form>
                    @else
                        <form action="{{route('admin.ban.user', ['user' => $review->user->id])}}" method="POST"
                            data-user-id="{{$review->user->id}}" class="ban-user-form">
                            @csrf
                            @method('PUT')
                            <a href="#" class="fa-solid fa-ban ban-user" data-user-id="{{$review->user->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/review.title_ban_user')}}"></a>
                        </form>
                    @endif

                    <form action="{{route('admin.delete.review', ['review' => $review->id])}}" method="POST" data-review-id="{{$review->id}}"
                        class="admin-delete-review-form">
                        @csrf
                        @method('DELETE')
                        <a href="#" class="fas fa-trash delete-review" data-review-id="{{$review->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/review.title_delete_user_review')}}"></a>
                    </form>

                    <form action="{{route('admin.unpublish.review', ['review' => $review->id])}}" method="POST" data-review-id="{{$review->id}}"
                        class="admin-unpublish-review-form">
                        @csrf
                        @method('PUT')
                        <a href="#" class="fa-solid fa-comment unpublish-review" data-book-title="{{ $review->book->title }}" data-review-id="{{$review->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/review.title_unpublish_review')}}"></a>
                    </form>
                </div>
            @endif

            <a href="#"
                @class(['fa-solid fa-arrow-up upvote-review', 'active' => $review->upvoted > 0])
                title="{{ $review->upvoted > 0 ? __('components/review.title_downvote') : __('components/review.title_upvote') }}"
                data-review-id="{{$review->id}}"
                data-book-id="{{$review->book->id}}"></a>
            <span class="number-of-upvotes">{{$review->upvotes_count ?? $review->upvotes->count()}}</span>

        </div>
    </div>

    <div class="middle">
        <div class="review">
            {{$review->review}}
        </div>
    </div>

</div>
