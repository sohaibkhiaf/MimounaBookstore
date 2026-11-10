<div class="admin-review-container">

    <div class="top">

        <div class="name">
            {{$review->user->name}} {{ __('components/admin-review.hardcoded_on') }} ` {{ $review->book->title }} `
            <span>{{ $review->edited ? __('components/admin-review.hardcoded_edited') : '' }}</span>
        </div>

        <div style="{{app()->getLocale() === 'ar' ? 'margin-right: auto;' : 'margin-left: auto;'}}" class="user-actions">

            <div class="admin-actions">

                @if ($review->user->banned)
                    <form action="{{route('admin.unban.user', ['user' => $review->user->id])}}" method="POST"
                        data-user-id="{{$review->user->id}}" class="unban-user-form">
                        @csrf
                        @method('PUT')
                        <a href="#" class="fa-solid fa-ban unban-user active" data-user-id="{{$review->user->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/admin-review.title_user_banned')}}"></a>
                    </form>
                @else
                    <form action="{{route('admin.ban.user', ['user' => $review->user->id])}}" method="POST"
                        data-user-id="{{$review->user->id}}" class="ban-user-form">
                        @csrf
                        @method('PUT')
                        <a href="#" class="fa-solid fa-ban ban-user" data-user-id="{{$review->user->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/admin-review.title_ban_user')}}"></a>
                    </form>
                @endif

                <form action="{{route('admin.delete.review', ['review' => $review->id])}}" method="POST" data-review-id="{{$review->id}}"
                    class="admin-delete-review-form">
                    @csrf
                    @method('DELETE')
                    <a href="#" class="fas fa-trash delete-review" data-review-id="{{$review->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/admin-review.title_delete_user_review')}}"></a>
                </form>

                <form action="{{route('admin.publish.review', ['review' => $review->id])}}" method="POST" data-review-id="{{$review->id}}"
                    class="admin-publish-review-form">
                    @csrf
                    @method('PUT')
                    <a href="#" class="fa-solid fa-comment publish-review" data-book-title="{{ $review->book->title }}" data-review-id="{{$review->id}}" data-user-name="{{$review->user->name}}" title="{{__('components/admin-review.title_publish_review')}}"></a>
                </form>

            </div>

            <a href="#"
                @class(['fa-solid fa-arrow-up upvote-review', 'active' => $review->upvoted > 0])
                title="{{ $review->upvoted > 0 ? __('components/admin-review.title_downvote') : __('components/admin-review.title_upvote') }}"
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
