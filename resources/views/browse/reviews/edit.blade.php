@extends('layouts.app')

@section('title' , __('reviews/reviews-edit.title_edit_review'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/reviews/reviews-edit.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/review-form.css')}}"/>
@endsection

@section('content')

    <div class="edit-review">

        <x-review-form :user="auth()->user()" :review="$review" action="edit" />

    </div>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/reviews/reviews-edit.js')}}"></script>
@endsection
