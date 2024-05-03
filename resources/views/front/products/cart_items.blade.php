<?php 
use App\Models\Product;
?>
<!--====== Section 1 ======-->
<div class="u-s-p-y-10">

    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="breadcrumb">
                <div class="breadcrumb__wrap">
                    <ul class="breadcrumb__list">
                        <li class="has-separator">

                            <a href="index.html">Home</a></li>
                        <li class="is-marked">

                            <a href="{{ url('front/cart')}}">Cart</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--====== End - Section 1 ======-->


<!--====== Section 2 ======-->
<div class="u-s-p-b-10">

    <!--====== Section Intro ======-->
    <div class="section__intro u-s-m-b-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__text-wrap">
                        <h1 class="section__heading u-c-secondary">SHOPPING CART</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Intro ======-->


    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                    <div class="table-responsive">
                        <table class="table-p">
                            <tbody>
                                @php $total_price = 0 @endphp
                                @foreach($getCartItems as $item)
                                <?php 
                                $getAttributePrice = Product::getAttributePrice($item['product_id'],$item['product_style']);
                                // dd($getAttributePrice);
                                ?>
                                <!--====== Row ======-->
                                <tr>
                                    <td>
                                        <div class="table-p__box">
                                            <div class="table-p__img-wrap">
                                            @if(isset($item['product']['images'][0]['image']) && !empty($item['product']['images'][0]['image']))
                                            <a href="{{url('product/'.$item['product']['id'])}}"><img class="u-img-fluid" src="{{ asset('front/images/products/small/'.$item['product']['images'][0]['image']) }}" alt=""></a>
                                            @else
                                            <a href="{{url('product/'.$item['product']['id'])}}"><img class="u-img-fluid" src="{{ asset('front/images/products/sitemakers-tshirt.png') }}" alt=""></a>
                                            @endif
                                        </div>
                                            <div class="table-p__info">
                                                <span class="table-p__name">
                                                    <a href="{{url('product/'.$item['product']['id'])}}">{{$item['product']['product_name']}}</a></span>
                                                <ul class="table-p__variant-list">
                                                    <li>
                                                        <span>STYLE: {{$item['product_style']}}</span></li>
                                                    <li>
                                                        <span>Color: {{$item['product']['product_color']}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- <span class="table-p__price">${{ $item['product']['final_price']*$item['product_qty'] }}</span> -->
                                        <div class="pd-detail__inline getAttributePrice">
                                            <span class="pd-detail__price" style="font-size: 16px;">${{ $getAttributePrice['final_price']*$item['product_qty'] }}</span>
                                            @if($getAttributePrice['discount'] > 0)
                                            <span class="pd-detail__discount">({{ $getAttributePrice['discount_percent'] }}% OFF)</span><del class="pd-detail__del">${{ $getAttributePrice['product_price']*$item['product_qty'] }}</del>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-p__input-counter-wrap">
                                            <!--====== Input Counter ======-->
                                            <div class="input-counter">
                                                <span class="input-counter__minus fas fa-minus updateCartItem qtyMinus" data-cartid="{{$item['id']}}" data-qty="{{$item['product_qty']}}"></span>
                                                <input class="input-counter__text input-counter--text-primary-style" type="text" value="{{$item['product_qty']}}" data-min="1" data-max="1000">
                                                <span class="input-counter__plus fas fa-plus updateCartItem qtyPlus" data-cartid="{{$item['id']}}" data-qty="{{$item['product_qty']}}"></span></div>
                                            <!--====== End - Input Counter ======-->
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-p__del-wrap">
                                            <a class="far fa-trash-alt table-p__delete-link deleteCartItem" href="#" data-cartid="{{$item['id']}}"></a>
                                        </div>
                                    </td>
                                </tr>
                                <!--====== End - Row ======-->
                                @php $total_price = $total_price + ($getAttributePrice['final_price']*$item['product_qty'])  @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="route-box">
                        <div class="route-box__g1">

                            <a class="route-box__link" href="shop-side-version-2.html"><i class="fas fa-long-arrow-alt-left"></i>

                                <span>CONTINUE SHOPPING</span></a></div>
                        <div class="route-box__g2">

                            <a class="route-box__link emptyCart" href="javascrip:;"><i class="fas fa-trash"></i>
                                <span>CLEAR CART</span>
                            </a>

                            <!-- <a class="route-box__link" href="cart.html"><i class="fas fa-sync"></i>
                                <span>UPDATE CART</span>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
<!--====== End - Section 2 ======-->


<!--====== Section 3 ======-->
<div class="u-s-p-b-60">

    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                    <form class="f-cart">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 u-s-m-b-30">
                            </div>
                            <div class="col-lg-4 col-md-6 u-s-m-b-30">
                            </div>
                            <div class="col-lg-4 col-md-6 u-s-m-b-30">
                                <div class="f-cart__pad-box">
                                    <div class="u-s-m-b-30">
                                        <table class="f-cart__table">
                                            <tbody>
                                                <tr>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td>GRAND TOTAL</td>
                                                    <td>${{$total_price}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>

                                        <a href="{{url('checkout')}}"><button class="btn btn--e-brand-b-2"> PROCEED TO CHECKOUT</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
<!--====== End - Section 3 ======-->
