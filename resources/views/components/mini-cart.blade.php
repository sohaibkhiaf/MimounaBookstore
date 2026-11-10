<aside class="mini-cart" id="miniCart"
    data-currency="{{__('components/mini-cart.hardcoded_da')}}"
    data-empty-text="{{__('components/mini-cart.empty_cart')}}"
    data-qty-label="{{__('components/mini-cart.label_quantity')}}"
    data-remove-title="{{__('components/mini-cart.button_remove')}}"
    data-minimize-title="{{__('components/mini-cart.title_minimize')}}"
    data-maximize-title="{{__('components/mini-cart.title_maximize')}}">

    {{-- Minimized / Collapsed Pill Button --}}
    <button type="button" class="mini-cart-collapsed-btn" title="{{__('components/mini-cart.title_maximize')}}">
        <span class="mini-cart-collapsed-icon">
            <i class="fas fa-shopping-cart"></i>
            <span class="mini-cart-badge">0</span>
        </span>
        <span class="mini-cart-collapsed-info">
            <span class="mini-cart-collapsed-title">{{__('components/mini-cart.header_mini_cart')}}</span>
            <span class="mini-cart-collapsed-total">0 {{__('components/mini-cart.hardcoded_da')}}</span>
        </span>
        <i class="fa-solid fa-expand mini-cart-expand-icon"></i>
    </button>

    {{-- Expanded Panel --}}
    <div class="mini-cart-panel">
        <div class="mini-cart-header">
            <div class="mini-cart-header-title">
                <i class="fas fa-shopping-cart"></i>
                <h3>{{__('components/mini-cart.header_mini_cart')}}</h3>
                <span class="mini-cart-count">(0)</span>
            </div>
            <button type="button" class="mini-cart-toggle-btn" title="{{__('components/mini-cart.title_minimize')}}">
                <i class="fa-solid fa-minus"></i>
            </button>
        </div>

        <div class="mini-cart-body">
            <div class="mini-cart-items"></div>
            <div class="mini-cart-empty">
                <i class="fa-solid fa-cart-shopping"></i>
                <p>{{__('components/mini-cart.empty_cart')}}</p>
            </div>
        </div>

        <div class="mini-cart-footer">
            <div class="mini-cart-total-row">
                <span class="mini-cart-total-label">{{__('components/mini-cart.label_total')}}:</span>
                <span class="mini-cart-total-amount">0 {{__('components/mini-cart.hardcoded_da')}}</span>
            </div>
            <a href="{{route('browse.cart')}}" class="mini-cart-checkout-btn">
                <span>{{__('components/mini-cart.button_go_to_cart')}}</span>
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </div>

</aside>

