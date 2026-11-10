<div class="form-container">

    <form method="POST" action="{{ $action === 'edit' ? route('admin.orders.update', ['order' => $order->id])
        : route('admin.orders.store')}}">
        @csrf
        @if ($action == 'edit')
            @method('PUT')
        @endif

        <h3>{{ $action === 'edit' ? __('components/order-form.header_edit').' `#'.$order->id.'`' : __('components/order-form.header_add')}}</h3>

        <span>{{__('components/order-form.label_subtotal')}}*</span>
        <input type="number" name="subtotal" class="box" value="{{$action === 'edit' ? $order->subtotal : old('subtotal')}}" required/>
        @error('subtotal')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_shipping')}}*</span>
        <input type="number" name="shipping" class="box" value="{{$action === 'edit' ? $order->shipping : old('shipping')}}" required/>
        @error('shipping')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_total')}}*</span>
        <input type="number" name="total" class="box" value="{{$action === 'edit' ? $order->total : old('total')}}" disabled/>
        @error('total')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_shipping_region')}}*</span>
        <input type="text" name="shipping-region" class="box" value="{{$action === 'edit' ? $order->shipping_region : old('shipping-region')}}" maxlength="255" required/>
        @error('shipping-region')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_shipping_address')}}*</span>
        <input type="text" name="shipping-address" class="box" value="{{$action === 'edit' ? $order->shipping_address : old('shipping-address')}}" maxlength="1024" required/>
        @error('shipping-address')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_shipping_type')}}*</span>
        <input type="text" name="shipping-type" class="box" value="{{$action === 'edit' ? $order->shipping_type : old('shipping-type')}}" maxlength="255" required/>
        @error('shipping-type')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_recipient_name')}}*</span>
        <input type="text" name="shipping-name" class="box" value="{{$action === 'edit' ? $order->shipping_name : old('shipping-name')}}" maxlength="255" required/>
        @error('shipping-name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/order-form.label_recipient_phone')}}*</span>
        <input type="text" name="shipping-phone" class="box" value="{{$action === 'edit' ? $order->shipping_phone : old('shipping-phone')}}" maxlength="10" required/>
        @error('shipping-phone')
            <div class="error">{{$message}}</div>
        @enderror

        <h3 style="margin-top: 4rem;">{{__('components/order-form.header_order_details')}}</h3>

        @if ($action === 'edit')
            @foreach ($order->orderDetails as $detail)
                <div class="order-details">
                    <span>{{__('components/order-form.label_book_title')}}*</span>
                    <input type="text" name="book-title-{{$detail->id}}" class="box" value="{{$detail->book_title}}" maxlength="255" required/>

                    <span>{{__('components/order-form.label_quantity')}}*</span>
                    <input type="number" name="quantity-ordered-{{$detail->id}}" class="box" value="{{$detail->quantity}}" required/>

                    <span>{{__('components/order-form.label_unit_price')}}*</span>
                    <input type="number" name="unit-price-{{$detail->id}}" class="box" value="{{$detail->unit_price}}" required/>
                </div>
            @endforeach
        @else
            @for ($i = 0; $i < 5; $i++)
                <div class="order-details">
                    <span>{{__('components/order-form.label_book_title')}} ({{$i+1}}){{$i === 0 ? '*' : ''}}</span>
                    <input type="text" name="book-title-{{$i}}" class="box" value="{{old('book-title-'.$i)}}" maxlength="255" {{$i === 0 ? 'required' : ''}}/>

                    <span>{{__('components/order-form.label_quantity')}}{{$i === 0 ? '*' : ''}}</span>
                    <input type="number" name="quantity-ordered-{{$i}}" class="box" value="{{old('quantity-ordered-'.$i)}}" {{$i === 0 ? 'required' : ''}}/>

                    <span>{{__('components/order-form.label_unit_price')}}{{$i === 0 ? '*' : ''}}</span>
                    <input type="number" name="unit-price-{{$i}}" class="box" value="{{old('unit-price-'.$i)}}" {{$i === 0 ? 'required' : ''}}/>
                </div>
            @endfor
        @endif

        @if ($action === 'edit')
            <div class="buttons-container">
                <a href="{{route('admin.orders')}}" class="cancel-button">{{__('components/order-form.button_cancel')}}</a>
                <input type="submit" value="{{__('components/order-form.button_edit')}}" class="edit-button" name="edit-order"/>
            </div>
        @else
            <input type="submit" value="{{__('components/order-form.button_add')}}" class="add-button" name="add-order"/>
        @endif

    </form>

</div>

