@extends('layouts.app')

@section('title' , __('browse/cart.title_cart'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/cart.css')}}"/>
@endsection

@section('content')

    @isset($_GET['created'])
        @section('alert')
            <div class="green-alert">
                {{__('browse/cart.alert_order_created')}}
            </div>
        @endsection
    @endisset

    <section class="cart">

        <div class="cart-container">

            <h3>{{__('browse/cart.header_cart')}}<span></span></h3>

            <table>

                <tbody>
                    <tr>
                        <th>{{__('browse/cart.table_header_book')}}</th>
                        <th>{{__('browse/cart.table_header_price')}}</th>
                        <th>{{__('browse/cart.table_header_quantity')}}</th>
                        <th>{{__('browse/cart.table_header_amount')}}</th>
                        <th>{{__('browse/cart.table_header_actions')}}</th>
                    </tr>

                    <tr>
                        <td style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}" colspan="3">
                            {{__('browse/cart.table_data_amount')}}
                        </td>
                        <td class="subtotal">-</td>
                        <td>-</td>
                    </tr>

                    <tr>

                        @if (null !== auth()->user())
                            <td style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}" colspan="3">

                                @if (auth()->user()->region->enabled)
                                    {{__('browse/cart.hardcoded_shipping_to_algeria')}}{{(app()->getLocale() === 'ar') ? '،' : ','}}<br>
                                    {{(app()->getLocale() === 'ar') ? auth()->user()->region->ar_name : auth()->user()->region->fr_name}}{{(app()->getLocale() === 'ar') ? '،' : ','}} <br>
                                    {{auth()->user()->address}} {{(app()->getLocale() === 'ar') ? '،' : ','}}<br>
                                    <select class="shipping-price-selector" data-home-shipping="{{auth()->user()->region->a_domicile}}"
                                        data-desk-shipping="{{auth()->user()->region->stop_desk}}">
                                        <option value="1" selected> {{__('browse/cart.shipping_type_home')}} ({{auth()->user()->region->a_domicile}}{{__('browse/cart.hardcoded_da')}})</option>
                                        <option value="2"> {{__('browse/cart.shipping_type_stop_desk')}} ({{auth()->user()->region->stop_desk}}{{__('browse/cart.hardcoded_da')}})</option>
                                    </select>
                                    <br>{{auth()->user()->name}}
                                    <br>{{auth()->user()->phone}}
                                @else
                                    <p class="shipping-unavailable">
                                        {{__('browse/cart.table_data_shipping_unavailable' , ['region_name' => (app()->getLocale() === 'ar') ?
                                                                auth()->user()->region->ar_name : auth()->user()->region->fr_name])}}
                                    </p>
                                @endif

                            </td>
                            <td class="shipping-price" data-region-id="{{auth()->user()->region->id}}">
                                @if (auth()->user()->region->enabled)
                                    {{auth()->user()->region->stop_desk}}{{__('browse/cart.hardcoded_da')}}
                                @else
                                    -
                                @endif
                            </td>
                            <td> <a class="edit">{{__('browse/cart.button_edit')}}</a></td>
                        @else
                            <td style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}" colspan="3">
                                <a class="register-to-checkout">{{__('browse/cart.action_create_account')}}<a>
                                {{__('browse/cart.login_message_part_or')}} <a class="login-to-checkout">{{__('browse/cart.action_login')}}<a>
                                {{__('browse/cart.login_message_part_able')}}<br>{{__('browse/cart.login_message_part_correct')}}
                            </td>
                            <td class="shipping-price" data-region-id="0">-</td>
                            <td>-</td>
                        @endif

                    </tr>

                    <tr>
                        <td style="{{(app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}" colspan="3">{{__('browse/cart.table_data_total_amount')}}</td>
                        <td class="total">-</td>
                        <td>
                            @if (auth()->check())
                                @if (auth()->user()->region->enabled)
                                    <a class="checkout">{{__('browse/cart.button_checkout')}}</a>
                                @else
                                    -
                                @endif
                            @else
                                <a class="checkout">{{__('browse/cart.button_checkout')}}</a>
                            @endif

                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/browse/cart.js')}}"></script>
@endsection

