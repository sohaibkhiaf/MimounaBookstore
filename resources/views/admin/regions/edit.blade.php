@extends('layouts.app-admin')

@section('title' , __('admin/regions-edit.title_edit_region'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/regions-edit.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/region-form.css')}}"/>
@endsection

@section('content')
    
    <section class="edit-region">

        <x-region-form :$region />

    </section>

@endsection
