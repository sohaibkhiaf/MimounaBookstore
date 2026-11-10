@extends('layouts.app-admin')

@section('title' , __('admin/orders-create.title_add_order'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/orders-create.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/order-form.css')}}"/>
@endsection

@section('content')

    <section class="create-order">

        <x-order-form action="create"/>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/components/order-form.js')}}"></script>
@endsection
