@extends('layouts.app-admin')

@section('title' , __('admin/genres-create.title_add_genre'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/genres-create.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/genre-form.css')}}"/>
@endsection

@section('content')
    
    <section class="create-genre">

        <x-genre-form action="create" />

    </section>

@endsection
