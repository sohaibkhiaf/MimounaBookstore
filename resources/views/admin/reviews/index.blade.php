@extends('layouts.app-admin')

@section('title' , 'Client Reviews')

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/reviews-index.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/admin-review.css')}}"/>
@endsection

@section('content')

    <!-- -------------------------------------------- reviews section ------------------------------------------------ -->

    <section class="reviews">

        <div class="content-container">

            <div class="reviews-container">

                <h3>{{ __('admin/reviews-index.header_reviews_management') }}</h3>

                @if ($reviews->isNotEmpty())

                    @foreach ($reviews as $review)
                        <x-admin-review :review="$review" />
                    @endforeach

                    <div class="navigator-container">
                        {{ $reviews->links() }}
                    </div>

                @else

                    <div class="no-reviews-found">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        No Reviews Found
                        {{ __('admin/reviews-index.message_no_results') }}
                    </div>
                @endif

            </div>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/components/admin-review.js')}}"></script>
@endsection
