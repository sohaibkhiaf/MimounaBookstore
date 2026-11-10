@extends('layouts.app')

@section('title' , __('reviews/reviews-create.title_add_review'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/reviews/reviews-create.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/review-form.css')}}"/>
@endsection

@section('content')

    <div class="create-review">

        <x-review-form :user="auth()->user()" :book="$book" action="create" />

    </div>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/reviews/reviews-create.js')}}"></script>
@endsection
