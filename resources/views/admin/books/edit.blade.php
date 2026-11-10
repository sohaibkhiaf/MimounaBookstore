@extends('layouts.app-admin')

@section('title' , __('admin/books-edit.title_edit_book'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/books-edit.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/book-form.css')}}"/>
@endsection

@section('content')
    
    <section class="edit-book">

        <x-book-form :$genres :$book action="edit" />

    </section>

@endsection
