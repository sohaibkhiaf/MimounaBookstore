@extends('layouts.app')

@section('title' , __('user/account.title_account'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/user/account.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/account-information.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/mini-cart.css')}}"/>
@endsection

@section('content')

    <x-mini-cart />

    @php
        $currentTab = $tab ?? 'account_info';
        $textAlignStyle = app()->getLocale() === 'ar' ? 'text-align: right;' : 'text-align: left;';
        $comma = app()->getLocale() === 'ar' ? '،' : ',';
    @endphp

    <section class="account">

        <!-- ---------------------------------- account section : tabs container ----------------------------------- -->

        <div class="tabs-container">

            <div style="{{app()->getLocale() === 'ar' ? 'justify-content: right;' : 'justify-content: left;'}}">
                <h3>{{auth()->user()->name}}</h3>
            </div>

            <a href="{{route('user.account', ['tab' => 'account_info'])}}" @class(['active' => $currentTab === 'account_info'])>
                <i class="fa-solid fa-user"></i> <span>{{__('user/account.tab_account_info')}}</span>
            </a>
            <a href="{{route('user.account', ['tab' => 'orders'])}}" @class(['active' => in_array($currentTab, ['orders', 'order_details'])])>
                <i class="fa-solid fa-box"></i> <span>{{__('user/account.tab_my_orders')}}</span>
            </a>

            @if (auth()->user()->role === 1)
                <a href="{{route('admin.orders')}}"><i class="fa-solid fa-user-tie"></i> <span>{{__('user/account.tab_admin_page')}}</span> </a>
            @endif

            <a href="#" class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket"></i> <span>{{__('user/account.tab_logout')}}</span> </a>

        </div>

        <!-- ---------------------------------- account section : content container -------------------------------- -->

        <div class="content-container">

            @if ($currentTab === 'account_info')

                <x-account-information :regions="\App\Models\Region::all()" :user="auth()->user()"
                    :action="$action ?? 'edit'" :intended="$intended ?? 'account'"/>

            @elseif ($currentTab === 'orders')

                <div class="orders">

                    <h3>{{__('user/account.header_my_orders')}}</h3>

                    @if ($orders->isNotEmpty())

                        <table>

                            <tr>
                                <th>{{__('user/account.table_header_order')}}</th>
                                <th>{{__('user/account.table_header_doc')}}</th>
                                <th>{{__('user/account.table_header_status')}}</th>
                                <th>{{__('user/account.table_header_total')}}</th>
                                <th>{{__('user/account.table_header_details')}}</th>
                            </tr>

                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{$order->id}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->orderStatus->message}}</td>
                                    <td>{{$order->total}}{{__('user/account.hardcoded_da')}}</td>
                                    <td>
                                        <a href="{{route('user.account', ['tab' => 'order_details', 'order_id' => $order->id])}}">
                                            <i class="fa-solid fa-circle-info show-order-details"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>

                        <div class="navigator-container">
                            {{ $orders->links() }}
                        </div>

                    @else
                        <div class="no-orders">
                            <i class="fa-solid fa-circle-exclamation"></i><br>
                            {{__('user/account.message_no_orders')}}{{$comma}}
                            <a href="{{route('browse.shop')}}">
                                {{__('user/account.message_shop_now')}}
                            </a>
                        </div>
                    @endif

                </div>

            @elseif ($currentTab === 'order_details' && isset($order))

                <div class="order-details">

                    <h3>{{__('user/account.header_order_details')}} <span>#{{$order->id}}</span></h3>

                    <table>

                        <tr>
                            <th>{{__('user/account.table_header_title')}}</th>
                            <th>{{__('user/account.table_header_price')}}</th>
                            <th>{{__('user/account.table_header_quantity')}}</th>
                            <th>{{__('user/account.table_header_amount')}}</th>
                        </tr>

                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <td>{{$detail->book_title}}</td>
                                <td>{{$detail->unit_price}}{{__('user/account.hardcoded_da')}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>{{$detail->unit_price * $detail->quantity}}{{__('user/account.hardcoded_da')}}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" style="{{$textAlignStyle}}">{{__('user/account.table_data_amount')}}</td>
                            <td>{{$order->subtotal}}{{__('user/account.hardcoded_da')}}</td>
                        </tr>

                        <tr>
                            <td colspan="3" style="{{$textAlignStyle}}">
                                {{__('user/account.hardcoded_shipping_to_algeria')}}{{$comma}}<br>
                                {{$order->shipping_region}}{{$comma}}<br>
                                {{$order->shipping_address}}{{$comma}}<br>
                                {{$order->shipping_type}}<br>
                                {{$order->shipping_name}}<br>
                                {{$order->shipping_phone}}<br>
                            </td>
                            <td>{{$order->shipping}}{{__('user/account.hardcoded_da')}}</td>
                        </tr>

                        <tr>
                            <td colspan="3" style="{{$textAlignStyle}}">{{__('user/account.table_data_total')}}</td>
                            <td>{{$order->total}}{{__('user/account.hardcoded_da')}}</td>
                        </tr>

                    </table>

                </div>

            @endif

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/user/account.js')}}"></script>
    <script type="module" src="{{url('js/components/mini-cart.js')}}"></script>
@endsection
