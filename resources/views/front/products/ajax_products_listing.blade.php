@foreach($categoryProducts as $product)
<div class="col-lg-4 col-md-6 col-sm-6">
    <div class="product-m">
        <div class="product-m__thumb">
            <a class="aspect aspect--bg-grey aspect--square u-d-block" href="{{url('product/'.$product['id'])}}">
            @if(isset($product['images'][0]['image']) && !empty($product['images'][0]['image']))
            <img class="aspect__img" src="{{ asset('front/images/products/small/'.$product['images'][0]['image']) }}" alt=""></a>
            @else
            <img class="aspect__img" src="{{ asset('front/images/products/sitemakers-tshirt.png') }}" alt=""></a>
            @endif
            <div class="product-m__quick-look">
                <a class="fas fa-search" data-modal="modal" data-modal-id="#quick-look" data-tooltip="tooltip" data-placement="top" title="Quick Look"></a></div>
            <div class="product-m__add-cart">
                <a class="btn--e-brand" data-modal="modal" data-modal-id="#add-to-cart">View Details</a></div>
        </div>
        <div class="product-m__content">
            <div class="product-m__name">
                <a href="{{url('product/'.$product['id'])}}">{{ $product['product_name'] }}</a></div>
            <div class="product-m__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                <span class="product-m__review">(25)</span></div>
            <div class="product-m__price">${{ $product['final_price'] }}
            @if($product['discount_type'] != "")
                <span class="product-o__discount">${{ $product['product_price'] }}</span>
            @endif
            </div>
            <div class="product-m__hover">
                <div class="product-m__preview-description">

                    <span>{{ $product['description'] }}</span></div>
                <div class="product-m__wishlist">

                    <a class="far fa-heart" href="#" data-tooltip="tooltip" data-placement="top" title="Add to Wishlist"></a></div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="u-s-p-y-60 pagination">
    <?php 
        if(!isset($_GET['sort'])){
            $_GET['sort'] = "";
        }
        if(!isset($_GET['color'])){
            $_GET['color'] = "";
        }
        if(!isset($_GET['style'])){
            $_GET['style'] = "";
        }
        if(!isset($_GET['price'])){
            $_GET['price'] = "";
        }
        if(!isset($_GET['Material'])){
            $_GET['Material'] = "";
        }
        if(!isset($_GET['Layers'])){
            $_GET['Layers'] = "";
        }
        if(!isset($_GET['Shape'])){
            $_GET['Shape'] = "";
        }
        if(!isset($_GET['Pieces'])){
            $_GET['Pieces'] = "";
        }
        if(!isset($_GET['Size'])){
            $_GET['Size'] = "";
        }
        

    ?>
    <!--====== Pagination ======-->
   
    {{ $categoryProducts->appends(['sort'=>$_GET['sort'],'color'=>$_GET['color'],'style'=>$_GET['style'],'price'=>$_GET['price'],'Material'=>
    $_GET['Material'],'Layers'=>$_GET['Layers'],'Shape'=>$_GET['Shape'],'Pieces'=>$_GET['Pieces'],'Size'=>$_GET['Size']]) ->links() }}

    <!--====== End - Pagination ======-->
</div>