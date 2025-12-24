@extends('layouts.app-admin')

@section('title' , __('admin/books-create.title_add_book'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/books-create.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-form.css')}}"/>
@endsection

@section('content')
    
    <section class="create-book">

        <x-book-form :$genres action="create" />

    </section>

@endsection
