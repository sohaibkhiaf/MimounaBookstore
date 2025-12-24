@extends('layouts.app')

@section('title' , __('user/account.title_account'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/user/account.css')}}"/>
    <link rel="stylesheet" href="{{url('css/components/account-information.css')}}"/>
@endsection

@section('content')

    <section class="account">

        <!-- ---------------------------------- account section : tabs container ----------------------------------- -->

        <div class="tabs-container">

            <div style="{{(app()->getLocale() === 'ar') ? 'justify-content: right;' : 'justify-content: left;'}}">
                <h3>{{auth()->user()->name}}</h3>
            </div>

            @isset($tab)
                <a href="{{route('user.account', ['tab' => 'account_info', 'action' => 'show' ])}}" class="{{$tab == 'account_info' ? 'active' : ''}}"><i class="fa-solid fa-user"></i> <span>{{__('user/account.tab_account_info')}}</span> </a>
                <a href="{{route('user.account', ['tab' => 'orders' ])}}" class="{{ ($tab == 'orders' || $tab == 'order_details') ? 'active' : ''}}"><i class="fa-solid fa-box"></i> <span>{{__('user/account.tab_my_orders')}}</span> </a>
            @else
                <a href="{{route('user.account', ['tab' => 'account_info', 'action' => 'show' ])}}" class="active"><i class="fa-solid fa-user"></i> <span>{{__('user/account.tab_account_info')}}</span> </a>
                <a href="{{route('user.account', ['tab' => 'orders' ])}}"><i class="fa-solid fa-box"></i> <span>{{__('user/account.tab_my_orders')}}</span> </a>
            @endisset

            @if (auth()->user()->role === 1)
                <a href="{{route('admin.orders')}}"><i class="fa-solid fa-user-tie"></i> <span>{{__('user/account.tab_admin_page')}}</span> </a>
            @endif

            <a href="#" class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket"></i> <span>{{__('user/account.tab_logout')}}</span> </a>

        </div>

        <!-- ---------------------------------- account section : content container -------------------------------- -->

        <div class="content-container">

            @isset($tab)

                @if ($tab === 'account_info')

                    <x-account-information :regions="\App\Models\Region::all()" :user="auth()->user()"
                        :action="$action??'show'" :intended="$intended??'account'"/>

                @elseif($tab === 'orders')

                    <div class="orders">

                        <h3>{{__('user/account.header_my_orders')}}</h3>

                        @if ($orders->count() > 0)

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
                                        <td>
                                            @if (app()->getLocale() === 'ar')
                                                {{ $order->orderStatus->ar_message }}
                                            @elseif (app()->getLocale() === 'fr')
                                                {{ $order->orderStatus->fr_message }}
                                            @else
                                                {{ $order->orderStatus->en_message }}
                                            @endif
                                        </td>
                                        {{-- <td>{{(app()->getLocale() === 'ar') ? $order->orderStatus->ar_message : $order->orderStatus->en_message}}</td> --}}
                                        <td>{{$order->total}}{{__('user/account.hardcoded_da')}}</td>
                                        <td>
                                            <a href="{{route('user.account' , ['tab' => 'order_details' , 'order_id' => $order->id ])}}">
                                                <i class="fa-solid fa-circle-info show-order-details"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>

                            <div class="navigator-container">

                                @if ($orders->currentPage() > 1)
                                    <a href="{{$orders->previousPageUrl().'&tab=orders'}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                                @else
                                    <a href="{{$orders->url($orders->currentPage()).'&tab=orders'}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                                @endif

                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    @if ($orders->currentPage() == $i)
                                        <a href="{{$orders->url($i).'&tab=orders'}}" class="active">{{$i}}</a>
                                    @else
                                        <a href="{{$orders->url($i).'&tab=orders'}}">{{$i}}</a>
                                    @endif
                                @endfor

                                @if ($orders->currentPage() < $orders->lastPage())
                                    <a href="{{$orders->nextPageUrl().'&tab=orders'}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                                @else
                                    <a href="{{$orders->url($orders->currentPage()).'&tab=orders'}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                                @endif

                            </div>

                        @else
                            <div class="no-orders">
                                <i class="fa-solid fa-circle-exclamation"></i><br>
                                {{__('user/account.message_no_orders')}}{{(app()->getLocale() === 'ar')?'،':','}}
                                <a href="{{route('browse.shop')}}">
                                    {{__('user/account.message_shop_now')}}
                                </a>
                            </div>
                        @endif

                    </div>

                @elseif($tab === 'order_details' && isset($order))

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
                                    <td>{{$detail->unit_price*$detail->quantity}}{{__('user/account.hardcoded_da')}}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">{{__('user/account.table_data_amount')}}</td>
                                <td>{{$order->subtotal}}{{__('user/account.hardcoded_da')}}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
                                    {{__('user/account.hardcoded_shipping_to_algeria')}}{{(app()->getLocale() === 'ar')?'،':','}}<br>
                                    {{$order->shipping_region}}{{(app()->getLocale() === 'ar')?'،':','}}<br>
                                    {{$order->shipping_address}}{{(app()->getLocale() === 'ar')?'،':','}}<br>
                                    {{$order->shipping_type}}<br>
                                    {{$order->shipping_name}}<br>
                                    {{$order->shipping_phone}}<br>
                                </td>
                                <td>{{$order->shipping}}{{__('user/account.hardcoded_da')}}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">{{__('user/account.table_data_total')}}</td>
                                <td>{{$order->total}}{{__('user/account.hardcoded_da')}}</td>
                            </tr>

                        </table>

                    </div>

                @endif

            @else

                <x-account-information :regions="App\Models\Region::all()" :user="auth()->user()"
                    :action="$action??'show'" :intended="$intended??'account'" />

            @endisset

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/user/account.js')}}"></script>
@endsection
