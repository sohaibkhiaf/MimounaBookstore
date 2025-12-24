@extends('layouts.app-admin')

@section('title' , __('admin/orders-show.title_order_details'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/orders-show.css')}}"/>
@endsection

@section('content')

    <!-- ------------------------------------------- details section ------------------------------------------------- -->

    <section class="details">

        <!-- ---------------------------------- details section : tabs container ------------------------------------- -->

        <div class="tabs-container">

            <h3>{{__('admin/orders-show.header_status')}}</h3>

            <a href="{{route('admin.orders' , ['tab' => 'processing'])}}" class="{{ $order->orderStatus->id == 1 ? 'active' : ''}}">
                <i class="fa-solid fa-gears"></i>
                <span>
                    @if (app()->getLocale() === 'ar')
                        {{ \App\Models\OrderStatus::find(1)->ar_message }}
                    @elseif (app()->getLocale() === 'fr')
                        {{ \App\Models\OrderStatus::find(1)->fr_message }}
                    @else
                        {{ \App\Models\OrderStatus::find(1)->en_message }}
                    @endif
                </span>
            </a>

            <a href="{{route('admin.orders' , ['tab' => 'delivering'])}}" class="{{ $order->orderStatus->id == 2 ? 'active' : ''}}">
                <i class="fa-solid fa-truck"></i>
                @if (app()->getLocale() === 'ar')
                    {{ \App\Models\OrderStatus::find(2)->ar_message }}
                @elseif (app()->getLocale() === 'fr')
                    {{ \App\Models\OrderStatus::find(2)->fr_message }}
                @else
                    {{ \App\Models\OrderStatus::find(2)->en_message }}
                @endif
            </a>

            <a href="{{route('admin.orders' , ['tab' => 'delivered'])}}" class="{{ $order->orderStatus->id == 3 ? 'active' : ''}}">
                <i class="fa-solid fa-box"></i>
                @if (app()->getLocale() === 'ar')
                    {{ \App\Models\OrderStatus::find(3)->ar_message }}
                @elseif (app()->getLocale() === 'fr')
                    {{ \App\Models\OrderStatus::find(3)->fr_message }}
                @else
                    {{ \App\Models\OrderStatus::find(3)->en_message }}
                @endif
            </a>

            <a href="{{route('admin.orders' , ['tab' => 'canceled'])}}" class="{{ $order->orderStatus->id == 4 ? 'active' : ''}}">
                <i class="fa-solid fa-ban"></i>
                @if (app()->getLocale() === 'ar')
                    {{ \App\Models\OrderStatus::find(4)->ar_message }}
                @elseif (app()->getLocale() === 'fr')
                    {{ \App\Models\OrderStatus::find(4)->fr_message }}
                @else
                    {{ \App\Models\OrderStatus::find(4)->en_message }}
                @endif
            </a>

            <a href="{{route('admin.orders' , ['tab' => 'returned'])}}" class="{{ $order->orderStatus->id == 5 ? 'active' : ''}}">
                <i class="fa-solid fa-rotate-left"></i>
                @if (app()->getLocale() === 'ar')
                    {{ \App\Models\OrderStatus::find(5)->ar_message }}
                @elseif (app()->getLocale() === 'fr')
                    {{ \App\Models\OrderStatus::find(5)->fr_message }}
                @else
                    {{ \App\Models\OrderStatus::find(5)->en_message }}
                @endif
            </a>

            <h3>{{__('admin/orders-show.header_actions')}}</h3>

            <a class="edit-order-button" href="{{route('admin.orders.edit' , ['order' => $order->id])}}"><i class="fas fa-pen"></i> {{__('admin/orders-show.action_edit_order')}} (`#{{$order->id}}`) <span></span></a>

            <form class="delete-order-form" data-order-id="{{$order->id}}" method="POST"
                action="{{route('admin.orders.delete' , ['order' => $order->id])}}" >
                @csrf
                @method('DELETE')
                <a href="#" class="delete-order-button" data-order-id="{{$order->id}}"><i class="fas fa-trash"></i> {{__('admin/orders-show.action_delete_order')}} (`#{{$order->id}}`) <span></span></a>
            </form>

        </div>

        <!-- ---------------------------------- details section : content container ---------------------------------- -->

        <div class="content-container">

            <div class="order-details">

                <h3> {{__('admin/orders-show.header_order_details')}} <span>(#{{$order->id}})</span></h3>

                <table>
                    <tr>
                        <th>{{__('admin/orders-show.table_header_title')}}</th>
                        <th>{{__('admin/orders-show.table_header_price')}}</th>
                        <th>{{__('admin/orders-show.table_header_quantity')}}</th>
                        <th>{{__('admin/orders-show.table_header_amount')}}</th>
                    </tr>

                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{$detail->book_title}}</td>
                            <td>{{$detail->unit_price}}{{__('admin/orders-show.hardcoded_da')}}</td>
                            <td>{{$detail->quantity}}</td>
                            <td>{{$detail->quantity*$detail->unit_price}}{{__('admin/orders-show.hardcoded_da')}}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="3" style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;' }}">
                            {{__('admin/orders-show.table_data_amount')}}
                        </td>
                        <td>{{$order->subtotal}}{{__('admin/orders-show.hardcoded_da')}}</td>
                    </tr>

                    <tr>
                        <td colspan="3" style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;' }}">
                            {{__('admin/orders-show.table_data_shipping')}}{{(app()->getLocale() === 'ar')? '،':',' }} <br>
                            {{$order->shipping_region}}{{(app()->getLocale() === 'ar')? '،':',' }} <br>
                            {{$order->shipping_address}}{{(app()->getLocale() === 'ar')? '،':',' }} <br>
                            {{$order->shipping_type}}<br>
                            {{$order->shipping_name}}<br>
                            {{$order->shipping_phone}}<br>
                            @if ($order->user !== null)
                                {{__('admin/orders-show.table_data_delivered')}} {{$order->user->orders()->where('order_status_id', '=', 3)->count()}} <br>
                                {{__('admin/orders-show.table_data_returned')}} {{$order->user->orders()->where('order_status_id', '=', 5)->count()}} <br>
                            @endif

                        </td>

                        <td>{{$order->shipping}}{{__('admin/orders-show.hardcoded_da')}}</td>
                    </tr>

                    <tr>
                        <td colspan="3" style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;' }}">
                            {{__('admin/orders-show.table_data_total')}}
                        </td>
                        <td>{{$order->total}}{{__('admin/orders-show.hardcoded_da')}}</td>
                    </tr>

                </table>

            </div>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/admin/orders-show.js')}}"></script>
@endsection
