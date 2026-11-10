@extends('layouts.app-admin')

@section('title' , __('admin/orders-index.title_orders'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/orders-index.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/admin-orders.css')}}"/>
@endsection

@section('content')

    @php
        $currentTab = $tab ?? 'processing';
        $statusMap = $statuses ?? \App\Models\OrderStatus::all()->keyBy('id');
        $tabs = [
            'processing' => ['id' => 1, 'icon' => 'fa-solid fa-gears'],
            'delivering' => ['id' => 2, 'icon' => 'fa-solid fa-truck'],
            'delivered'  => ['id' => 3, 'icon' => 'fa-solid fa-box'],
            'canceled'   => ['id' => 4, 'icon' => 'fa-solid fa-ban'],
            'returned'   => ['id' => 5, 'icon' => 'fa-solid fa-rotate-left'],
        ];
    @endphp

    <!-- ------------------------------------------- orders section ------------------------------------------------- -->

    <section class="orders">

        <!-- ---------------------------------- orders section : tabs container ------------------------------------- -->

        <div class="tabs-container">

            <h3>{{__('admin/orders-index.header_status')}}</h3>

            @foreach ($tabs as $tabKey => $meta)
                <a href="{{route('admin.orders', ['tab' => $tabKey])}}" @class(['active' => $currentTab === $tabKey])>
                    <i class="{{$meta['icon']}}"></i>
                    {{$statusMap[$meta['id']]->message}}
                </a>
            @endforeach

            <h3>{{__('admin/orders-index.header_actions')}}</h3>

            <a href="{{route('admin.orders.create')}}"><i class="fas fa-plus"></i> {{__('admin/orders-index.action_add_order')}}</a>

        </div>

        <!-- ---------------------------------- orders section : content container ---------------------------------- -->

        <div class="content-container">

            <x-admin-orders :tab="$currentTab" :$orders />

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/components/admin-orders.js')}}"></script>
@endsection
