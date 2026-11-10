@extends('layouts.app-admin')

@section('title' , __('admin/orders-edit.title_edit_order'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/orders-edit.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/order-form.css')}}"/>
@endsection

@section('content')

    <section class="edit-order">

        <x-order-form :$order action="edit"/>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/components/order-form.js')}}"></script>
@endsection
