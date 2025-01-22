<div class="total-cost-wrapper">

    @php($shippingMethod = getWebConfig(name: 'shipping_method'))
    @php($product_price_total=0)
    @php($total_tax=0)
    @php($total_shipping_cost=0)
    @php($order_wise_shipping_discount=\App\Utils\CartManager::order_wise_shipping_discount())
    @php($total_discount_on_product=0)
    @php($cart=\App\Utils\CartManager::getCartListQuery(type: 'checked'))
    @php($cartAll=\App\Utils\CartManager::getCartListQuery())
    @php($cart_group_ids=\App\Utils\CartManager::get_cart_group_ids())
    @php($shipping_cost=\App\Utils\CartManager::get_shipping_cost(type: 'checked'))
    @php($get_shipping_cost_saved_for_free_delivery=\App\Utils\CartManager::getShippingCostSavedForFreeDelivery(type: 'checked'))
    @php($coupon_dis=0)
    @if($cart->count() > 0)
        @foreach($cart as $key => $cartItem)
            @php($product_price_total+=$cartItem['price']*$cartItem['quantity'])
            @php($total_tax+=$cartItem['tax_model']=='exclude' ? ($cartItem['tax']*$cartItem['quantity']):0)
            @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
        @endforeach

        @if(session()->missing('coupon_type') || session('coupon_type') !='free_delivery')
            @php($total_shipping_cost=$shipping_cost - $get_shipping_cost_saved_for_free_delivery)
        @else
            @php($total_shipping_cost=$shipping_cost)
        @endif
    @endif


    @if($cartAll->count() > 0 && $cart->count() == 0)
        <p class="mb-2 text-center">{{ translate('Please_checked_items_before_proceeding_to_checkout') }}</p>
    @elseif($cartAll->count() == 0)
        <p class="mb-2 text-center">{{ translate('empty_cart') }}</p>
    @endif

    <h6 class="text-center title font-medium letter-spacing-0 mb-20px text-capitalize">{{ translate('totals_cost') }}</h6>

    <div class="total-cost-area">
        @if(auth('customer')->check() && !session()->has('coupon_discount'))
            @php($coupon_discount = 0)
            <form action="javascript:" method="post" novalidate id="coupon-code-ajax">
                <div class="apply-coupon-form">
                    <input type="text" class="form-control" name="code" id="promo-code"
                           placeholder="{{ translate('apply_coupon_code') }}" required autocomplete="off">
                    <button class="btn badge-soft-base" id="coupon_code_theme_fashion">{{ translate('apply') }}</button>
                </div>
                <span id="coupon-apply" data-url="{{ route('coupon.apply') }}"></span>
            </form>
            @php($coupon_dis=0)
        @endif


        <ul class="total-cost-info border-bottom-0 border-bottom-sm mt-20px mb-30px text-capitalize">
            <li>
                <span>{{ translate('item_price') }}</span>
                <span>{{webCurrencyConverter($product_price_total)}}</span>
            </li>
            <li>
                <span>{{ translate('product_discount') }}</span>
                <span>-{{webCurrencyConverter($total_discount_on_product)}}</span>
            </li>
            <li>
                <span>{{ translate('sub_total') }}</span>
                <span>{{webCurrencyConverter($product_price_total - $total_discount_on_product)}}</span>
            </li>
            <li>
                <span>{{ translate('shipping') }}</span>
                <span>{{webCurrencyConverter($total_shipping_cost)}}</span>
            </li>
            <li>
                <span>{{ translate('tax') }}</span>
                <span>{{webCurrencyConverter($total_tax)}}</span>
            </li>
            @if(auth('customer')->check() && session()->has('coupon_discount'))
                @php($coupon_discount = session()->has('coupon_discount')?session('coupon_discount'):0)
                <li>
                    <span>{{ translate('coupon_discount') }} </span>
                    <span>-{{webCurrencyConverter($coupon_discount+$order_wise_shipping_discount)}}</span>
                </li>
                @php($coupon_dis=session('coupon_discount'))
            @endif
        </ul>
        <hr/>
        <div class="d-block d-md-none">
            <h6 class="d-flex justify-content-center gap-2 mb-2 justify-content-sm-between letter-spacing-0 font-semibold text-normal">
                <span>{{ translate('total') }}</span>
                <span>{{webCurrencyConverter($product_price_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product-$order_wise_shipping_discount)}}</span>
            </h6>
        </div>
        <div class="proceed-cart-btn">
            <h6 class="d-flex justify-content-center gap-2 mb-2 justify-content-sm-between letter-spacing-0 font-semibold text-normal">
                <span>{{ translate('total') }}</span>
                <span>{{webCurrencyConverter($product_price_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product-$order_wise_shipping_discount)}}</span>
            </h6>
            <ul class="total-cost-delivery-info mt-30px mb-32px">
                @php($refund_day_limit = getWebConfig(name: 'refund_day_limit'))
                @if ($refund_day_limit > 0)
                    <li>
                        <img loading="lazy" src="{{theme_asset('assets/img/products/icons/delivery-charge.png')}}"
                             class="icons" alt="{{ translate('product') }}">
                        <div class="cont">
                            <div class="t-txt"><span
                                        class="text-capitalize">{{translate('product_refund_validity')}}</span>
                                <span>:</span>
                                <strong>{{$refund_day_limit}} {{translate('days_after_delivery')}}</strong></div>
                        </div>
                    </li>
                @endif

                <li>
                    <img loading="lazy" src="{{theme_asset('assets/img/products/icons/warranty.png')}}" class="icons"
                         alt="{{ translate('product') }}">
                    <div class="cont">
                        <div class="t-txt text-capitalize"><span>{{translate('Order_cancelation_availablity')}} </span>
                            <span>:</span>
                            <strong>{{translate('before_the_vendor_confirms_the_order')}} </strong>
                        </div>
                    </div>
                </li>
            </ul>
            <button class="btn btn-base w-100 justify-content-center mt-1 form-control h-42px text-capitalize checkout_action {{$cart->count() <= 0 ? 'custom-disabled' : ''}}"
                    {{ (isset($product_null_status) && $product_null_status == 1) ? 'custom-disabled':''}}
                    type="button">{{ translate('proceed_to_checkout') }}</button>
        </div>
    </div>
</div>
