<div class="{{$tab}}">

    <h3> {{__('components/admin-orders.header_'.$tab)}} </h3>

    @if ($orders->count() > 0)

        <table>

            <tr>
                <th class="order-header" data-header-order="{{__('components/admin-orders.table_header_order')}}"
                    data-header-o="{{__('components/admin-orders.table_header_o')}}">
                    {{__('components/admin-orders.table_header_order')}}
                </th>
                <th>{{__('components/admin-orders.table_header_receiver')}}</th>
                <th>{{__('components/admin-orders.table_header_total')}}</th>
                <th class="details-header" data-header-details="{{__('components/admin-orders.table_header_details')}}"
                    data-header-d="{{__('components/admin-orders.table_header_d')}}">
                    {{__('components/admin-orders.table_header_details')}}
                </th>

                @if ($tab == 'processing')
                    <th class="send-header" data-header-send="{{__('components/admin-orders.table_header_send')}}"
                        data-header-s="{{__('components/admin-orders.table_header_s')}}">
                        {{__('components/admin-orders.table_header_send')}}
                    </th>
                    <th class="cancel-header" data-header-cancel="{{__('components/admin-orders.table_header_cancel')}}"
                        data-header-c="{{__('components/admin-orders.table_header_c')}}">
                        {{__('components/admin-orders.table_header_cancel')}}
                    </th>
                @elseif($tab == 'delivering')
                    <th class="deliver-header" data-header-deliver="{{__('components/admin-orders.table_header_deliver')}}"
                        data-header-d="{{__('components/admin-orders.table_header_d')}}">
                        {{__('components/admin-orders.table_header_deliver')}}
                    </th>
                    <th class="return-header" data-header-return="{{__('components/admin-orders.table_header_return')}}"
                        data-header-r="{{__('components/admin-orders.table_header_r')}}">
                        {{__('components/admin-orders.table_header_return')}}
                    </th>
                @endif

            </tr>

            @foreach ($orders as $order)
                <tr>
                    <td>#{{$order->id}}</td>
                    <td style="{{ (app()->getLocale() === 'ar') ? 'text-align: right;' : 'text-align: left;'}}">
                        {{__('components/admin-orders.hardcoded_shipping_to_algeria')}}{{(app()->getLocale() === 'ar')? '،':',' }}<br>
                        {{$order->shipping_region}}{{(app()->getLocale() === 'ar')?'،':','}}<br>
                        {{$order->shipping_address}}{{(app()->getLocale() === 'ar')?'،':','}}<br>
                        {{$order->shipping_type}}<br>
                        {{$order->shipping_name}}<br>
                        {{$order->shipping_phone}}<br>
                    </td>
                    <td>{{$order->total}}{{__('components/admin-orders.hardcoded_da')}}</td>
                    <td><a href="{{route('admin.orders.show' , ['order' => $order->id])}}"><i class="fa-solid fa-circle-info"></i></a></td>

                    @if ($tab == 'processing')
                        <td><i class="fa-solid fa-solid fa-truck start-delivery" data-order-id="{{$order->id}}"></i></td>
                        <td><i class="fa-solid fa-ban cancel-order" data-order-id="{{$order->id}}"></i></td>
                    @elseif($tab == 'delivering')
                        <td><i class="fa-solid fa-box order-delivered" data-order-id="{{$order->id}}"></i></td>
                        <td><i class="fa-solid fa-rotate-left order-returned" data-order-id="{{$order->id}}"></i></td>
                    @endif

                </tr>
            @endforeach

        </table>

        <div class="navigator-container">

            @if ($orders->currentPage() > 1)
                <a href="{{$orders->previousPageUrl().'&tab='.$tab}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
            @else
                <a href="{{$orders->url($orders->currentPage()).'&tab='.$tab}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
            @endif

            @for ($i = 1; $i <= $orders->lastPage(); $i++)
                @if ($orders->currentPage() == $i)
                    <a href="{{$orders->url($i).'&tab='.$tab}}" class="active">{{$i}}</a>
                @else
                    <a href="{{$orders->url($i).'&tab='.$tab}}">{{$i}}</a>
                @endif
            @endfor

            @if ($orders->currentPage() < $orders->lastPage())
                <a href="{{$orders->nextPageUrl().'&tab='.$tab}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
            @else
                <a href="{{$orders->url($orders->currentPage()).'&tab='.$tab}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
            @endif

        </div>

    @else
        <div class="no-orders">
            <i class="fa-solid fa-circle-exclamation"></i><br>
                {{__('components/admin-orders.message_no_'.$tab)}}
        </div>
    @endif

</div>
