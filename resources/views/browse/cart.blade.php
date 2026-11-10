@extends('layouts.app')

@section('title' , __('browse/cart.title_cart'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/browse/cart.css')}}"/>
@endsection

@section('content')

    @if (request()->has('created'))
        @section('alert')
            <div class="green-alert">
                {{__('browse/cart.alert_order_created')}}
            </div>
        @endsection
    @endif

    @php
        $textAlignStyle = app()->getLocale() === 'ar' ? 'text-align: right;' : 'text-align: left;';
        $comma = app()->getLocale() === 'ar' ? '،' : ',';
        $user = auth()->user();
        $regionsList = $regions ?? \App\Models\Region::all();
    @endphp

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
                        <td style="{{$textAlignStyle}}" colspan="3">
                            {{__('browse/cart.table_data_amount')}}
                        </td>
                        <td class="subtotal">-</td>
                        <td>-</td>
                    </tr>

                    <tr>

                        @auth
                            <td style="{{$textAlignStyle}}" colspan="3">

                                @if ($user->region->enabled)
                                    {{__('browse/cart.hardcoded_shipping_to_algeria')}}{{$comma}}<br>
                                    {{$user->region->name}}{{$comma}} <br>
                                    {{$user->address}} {{$comma}}<br>
                                    <select class="shipping-price-selector" data-home-shipping="{{$user->region->a_domicile}}"
                                        data-desk-shipping="{{$user->region->stop_desk}}">
                                        <option value="1" selected> {{__('browse/cart.shipping_type_home')}} ({{$user->region->a_domicile}}{{__('browse/cart.hardcoded_da')}})</option>
                                        <option value="2"> {{__('browse/cart.shipping_type_stop_desk')}} ({{$user->region->stop_desk}}{{__('browse/cart.hardcoded_da')}})</option>
                                    </select>
                                    <br>{{$user->name}}
                                    <br>{{$user->phone}}
                                @else
                                    <p class="shipping-unavailable">
                                        {{__('browse/cart.table_data_shipping_unavailable', ['region_name' => $user->region->name])}}
                                    </p>
                                @endif

                            </td>
                            <td class="shipping-price" data-region-id="{{$user->region->id}}">
                                @if ($user->region->enabled)
                                    {{$user->region->stop_desk}}{{__('browse/cart.hardcoded_da')}}
                                @else
                                    -
                                @endif
                            </td>
                            <td> <a class="edit">{{__('browse/cart.button_edit')}}</a></td>
                        @else
                            <td style="{{$textAlignStyle}}" colspan="3">

                                <div class="guest-auth-reminder">
                                    <i class="fa-solid fa-user-check"></i>
                                    <div>
                                        <a class="register-to-checkout">{{__('browse/cart.action_create_account')}}</a>
                                        {{__('browse/cart.login_message_part_or')}}
                                        <a class="login-to-checkout">{{__('browse/cart.action_login')}}</a>
                                        {{__('browse/cart.login_message_part_able')}}
                                    </div>
                                </div>

                                <div class="guest-shipping-form">
                                    <div class="guest-field">
                                        <label>{{__('browse/cart.guest_label_name')}}</label>
                                        <input type="text" class="guest-name" maxlength="50" placeholder="{{__('browse/cart.guest_placeholder_name')}}" required />
                                    </div>

                                    <div class="guest-field">
                                        <label>{{__('browse/cart.guest_label_phone')}}</label>
                                        <input type="tel" class="guest-phone" maxlength="10" dir="{{app()->getLocale() === 'ar' ? 'rtl' : 'ltr'}}" placeholder="{{__('browse/cart.guest_placeholder_phone')}}" required />
                                    </div>

                                    <div class="guest-field">
                                        <label>{{__('browse/cart.guest_label_region')}}</label>
                                        <select class="guest-region-selector" required>
                                            <option value="" data-enabled="0" data-home-shipping="0" data-desk-shipping="0" data-region-name="">
                                                {{__('browse/cart.guest_select_region')}}
                                            </option>
                                            @foreach ($regionsList as $region)
                                                <option value="{{$region->id}}"
                                                    data-enabled="{{$region->enabled ? 1 : 0}}"
                                                    data-home-shipping="{{$region->a_domicile}}"
                                                    data-desk-shipping="{{$region->stop_desk}}"
                                                    data-region-name="{{$region->name}}">
                                                    {{ str_pad($region->id, 2, '0', STR_PAD_LEFT) }} - {{$region->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="guest-field">
                                        <label>{{__('browse/cart.guest_label_shipping_type')}}</label>
                                        <select class="shipping-price-selector"
                                            data-home-shipping="0"
                                            data-desk-shipping="0"
                                            data-home-label="{{__('browse/cart.shipping_type_home')}}"
                                            data-desk-label="{{__('browse/cart.shipping_type_stop_desk')}}"
                                            disabled>
                                            <option value="1" selected>{{__('browse/cart.shipping_type_home')}}</option>
                                            <option value="2">{{__('browse/cart.shipping_type_stop_desk')}}</option>
                                        </select>
                                    </div>

                                    <div class="guest-field guest-field-full">
                                        <label>{{__('browse/cart.guest_label_address')}}</label>
                                        <input type="text" class="guest-address" maxlength="255" placeholder="{{__('browse/cart.guest_placeholder_address')}}" required />
                                    </div>
                                </div>

                                <p class="shipping-unavailable guest-shipping-unavailable"
                                    style="display: none;"
                                    data-template="{{__('browse/cart.table_data_shipping_unavailable', ['region_name' => ':region_name'])}}">
                                </p>

                                <p class="guest-form-error"
                                    style="display: none;"
                                    data-error-required="{{__('browse/cart.guest_error_required_fields')}}"
                                    data-error-phone="{{__('browse/cart.guest_error_invalid_phone')}}">
                                </p>

                                <p class="guest-accuracy-note">
                                    <i class="fa-solid fa-circle-info"></i>
                                    {{__('browse/cart.login_message_part_correct')}}
                                </p>

                            </td>
                            <td class="shipping-price" data-region-id="0">-</td>
                            <td>-</td>
                        @endauth

                    </tr>

                    <tr>
                        <td style="{{$textAlignStyle}}" colspan="3">{{__('browse/cart.table_data_total_amount')}}</td>
                        <td class="total">-</td>
                        <td>
                            @auth
                                @if ($user->region->enabled)
                                    <a class="checkout">{{__('browse/cart.button_checkout')}}</a>
                                @else
                                    -
                                @endif
                            @else
                                <a class="checkout">{{__('browse/cart.button_checkout')}}</a>
                            @endauth

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
