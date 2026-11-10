@extends('layouts.app-admin')

@section('title' , __('admin/genres-edit.title_edit_genre'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/genres-edit.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/genre-form.css')}}"/>
@endsection

@section('content')
    
    <section class="edit-genre">

        <x-genre-form action="edit" :$genre/>

    </section>

@endsection
