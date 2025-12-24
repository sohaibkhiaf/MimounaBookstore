@extends('layouts.app-admin')

@section('title' , __('admin/orders-index.title_orders'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/orders-index.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/admin-orders.css')}}"/>
@endsection

@section('content')

    <!-- ------------------------------------------- orders section ------------------------------------------------- -->

    <section class="orders">

        <!-- ---------------------------------- orders section : tabs container ------------------------------------- -->

        <div class="tabs-container">

            <h3>{{__('admin/orders-index.header_status')}}</h3>

            @isset($tab)

                <a href="{{route('admin.orders' , ['tab' => 'processing'])}}" class="{{ $tab == 'processing' ? 'active' : ''}}">
                    <i class="fa-solid fa-gears"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(1)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(1)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(1)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'delivering'])}}" class="{{ $tab == 'delivering' ? 'active' : ''}}">
                    <i class="fa-solid fa-truck"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(2)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(2)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(2)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'delivered'])}}" class="{{ $tab == 'delivered' ? 'active' : ''}}">
                    <i class="fa-solid fa-box"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(3)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(3)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(3)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'canceled'])}}" class="{{ $tab == 'canceled' ? 'active' : ''}}">
                    <i class="fa-solid fa-ban"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(4)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(4)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(4)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'returned'])}}" class="{{ $tab == 'returned' ? 'active' : ''}}">
                    <i class="fa-solid fa-rotate-left"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(5)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(5)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(5)->en_message }}
                    @endif
                </a>

            @else

                <a href="{{route('admin.orders' , ['tab' => 'processing'])}}" class="active">
                    <i class="fa-solid fa-gears"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(1)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(1)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(1)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'delivering'])}}" >
                    <i class="fa-solid fa-truck"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(2)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(2)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(2)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'delivered'])}}">
                    <i class="fa-solid fa-box"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(3)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(3)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(3)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'canceled'])}}">
                    <i class="fa-solid fa-ban"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(4)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(4)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(4)->en_message }}
                    @endif
                </a>

                <a href="{{route('admin.orders' , ['tab' => 'returned'])}}" >
                    <i class="fa-solid fa-rotate-left"></i>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(5)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(5)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(5)->en_message }}
                    @endif
                </a>
            @endisset

            <h3>{{__('admin/orders-index.header_actions')}}</h3>

            <a href="{{route('admin.orders.create')}}"><i class="fas fa-plus"></i> {{__('admin/orders-index.action_add_order')}}</a>

        </div>

        <!-- ---------------------------------- orders section : content container ---------------------------------- -->

        <div class="content-container">

            <x-admin-orders :tab="$tab ?? 'processing'" :$orders />

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/components/admin-orders.js')}}"></script>
@endsection
