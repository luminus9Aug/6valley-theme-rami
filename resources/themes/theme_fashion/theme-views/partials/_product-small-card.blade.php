<div class="similer-product-item">
    <div class="img">
        <a href="{{route('product',$product->slug)}}">
            <img loading="lazy" alt="{{ translate('products') }}"
                 src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'product') }}">
        </a>
        <a href="javascript:" class="wish-icon p-2 addWishlist_function_view_page" data-id="{{$product['id']}}">
            <i class="{{(isProductInWishList($product->id)?'bi-heart-fill text-danger':'bi-heart')}}  wishlist_{{$product['id']}}"></i>
        </a>
    </div>
    <div class="cont thisIsALinkElement" data-linkpath="{{route('product', $product->slug)}}">
        <h6 class="title">
            <a href="{{route('product',$product->slug)}}"
               title="{{ $product['name'] }}">{{ Str::limit($product['name'], 18) }}</a>
        </h6>
        <strong class="text-text-2">
            {{webCurrencyConverter(
                $product->unit_price-(\App\Utils\Helpers::getProductDiscount($product,$product->unit_price))
            )}}
        </strong>
    </div>
</div>
