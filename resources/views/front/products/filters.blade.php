<?php 
use App\Models\ProductsFilter; 
use App\Models\Category;
use Illuminate\Support\Facades\Route;
//Get Categories and their subcategories
$categories = Category::getCategories();
$url = Route::getFacadeRoot()->current()->uri;
$categoryDetails = Category::categoryDetails($url);
?>
<div class="shop-w-master">
    <h1 class="shop-w-master__heading u-s-m-b-30"><i class="fas fa-filter u-s-m-r-8"></i>
        <span>FILTERS</span></h1>
    <div class="shop-w-master__sidebar">
        <div class="u-s-m-b-30">
            <div class="shop-w shop-w--style">
                <div class="shop-w__intro-wrap">
                    <h1 class="shop-w__h">CATEGORY</h1>

                    <span class="fas fa-minus shop-w__toggle" data-target="#s-category" data-toggle="collapse"></span>
                </div>
                <div class="shop-w__wrap collapse show" id="s-category">
                    <ul class="shop-w__category-list gl-scroll">
                        @foreach($categories as $category)
                        <li class="has-list">
                            <a href="#">{{$category['category_name']}}</a>
                            <span class="js-shop-category-span is-expanded fas  @if(count($category['subcategories'])) fa-plus @endif u-s-m-l-6"></span>
                            @if(count($category['subcategories']))
                            <ul style="display:block">
                                @foreach($category['subcategories'] as $subcategory)
                                <li class="has-list">
                                    <a @if(isset($categoryDetails['categoryDetails']['parentcategory']['category_name']) && $categoryDetails['categoryDetails']
                                    ['parentcategory']['category_name'] == $subcategory['category_name']) style="color: #ff4500;" @elseif(isset($categoryDetails['categoryDetails']
                                    ['category_name']) && $categoryDetails['categoryDetails']['category_name'] == $subcategory['category_name']) style="color: #ff4500;" @endif
                                    href="{{ url( $subcategory['url'] )}}">{{ $subcategory['category_name']}}</a>
                                    <span class="js-shop-category-span fas @if(count($subcategory['subcategories'])) fa-plus @endif u-s-m-l-6"></span>
                                    @if(count($subcategory['subcategories']))
                                    <ul>
                                        @foreach($subcategory['subcategories'] as $subsubcategory)
                                        <li>
                                            <a  @if(isset($categoryDetails['categoryDetails']['parentcategory']['category_name']) && $categoryDetails['categoryDetails']
                                            ['parentcategory']['category_name'] == $subsubcategory['category_name']) style="color: #ff4500;" @elseif(isset($categoryDetails['categoryDetails']
                                            ['category_name']) && $categoryDetails['categoryDetails']['category_name'] == $subsubcategory['category_name']) style="color: #ff4500;" @endif 
                                            href="{{ url( $subsubcategory['url'] )}}">{{ $subsubcategory['category_name']}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="u-s-m-b-30">
            <div class="shop-w shop-w--style">
                <div class="shop-w__intro-wrap">
                    <h1 class="shop-w__h">RATING</h1>

                    <span class="fas fa-minus shop-w__toggle" data-target="#s-rating" data-toggle="collapse"></span>
                </div>
                <div class="shop-w__wrap collapse show" id="s-rating">
                    <ul class="shop-w__list gl-scroll">
                        <li>
                            <div class="rating__check">

                                <input type="checkbox">
                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            </div>

                            <span class="shop-w__total-text">(2)</span>
                        </li>
                        <li>
                            <div class="rating__check">

                                <input type="checkbox">
                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                    <span>& Up</span></div>
                            </div>

                            <span class="shop-w__total-text">(8)</span>
                        </li>
                        <li>
                            <div class="rating__check">

                                <input type="checkbox">
                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                    <span>& Up</span></div>
                            </div>

                            <span class="shop-w__total-text">(10)</span>
                        </li>
                        <li>
                            <div class="rating__check">

                                <input type="checkbox">
                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                    <span>& Up</span></div>
                            </div>

                            <span class="shop-w__total-text">(12)</span>
                        </li>
                        <li>
                            <div class="rating__check">

                                <input type="checkbox">
                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                    <span>& Up</span></div>
                            </div>

                            <span class="shop-w__total-text">(1)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="u-s-m-b-30">
            <div class="shop-w shop-w--style">
                <div class="shop-w__intro-wrap">
                    <h1 class="shop-w__h">STYLE</h1>

                    <span class="fas fa-minus shop-w__toggle" data-target="#s-size" data-toggle="collapse"></span>
                </div>
                <div class="shop-w__wrap collapse show" id="s-size">
                    <?php
                    $getStyles = ProductsFilter::getStyles($categoryDetails['catIds']);
                    ?>
                    <ul class="shop-w__list gl-scroll">
                        @foreach($getStyles as $key => $style)
                        <?php 
                         if(isset($_GET['style'])&& !empty($_GET['style'])){
                            $styles = explode('~',$_GET['style']);
                            if(!empty($styles)&&in_array($style,$styles)){
                                $stylechecked = 'checked';
                            }else{
                                $stylechecked = '';
                            }

                         }else{
                            $stylechecked = ''; 
                         }
                        ?>
                        <li>
                            <!--====== Check Box ======-->
                            <div class="check-box">
                                <input type="checkbox" id="style{{$key}}" name="style" value="{{$style}}" class="filterAjax" {{$stylechecked}}>
                                <div class="check-box__state check-box__state--primary">
                                    <label class="check-box__label" for="style{{$key}}">{{$style}}</label>
                                </div>
                            </div>
                            <!--====== End - Check Box ======-->
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="u-s-m-b-30">
            <div class="shop-w shop-w--style">
                <div class="shop-w__intro-wrap">
                    <h1 class="shop-w__h">PRICE</h1>

                    <span class="fas fa-minus shop-w__toggle" data-target="#s-price" data-toggle="collapse"></span>
                </div>
                <div class="shop-w__wrap collapse show" id="s-price">
                    <?php
                    $getPrices = array('0-100','101-500','501-1000','1001-2000','2001-5000','5001-10000');
                    ?>
                    <ul class="shop-w__list gl-scroll">
                        @foreach($getPrices as $key => $price)
                        <?php 
                         if(isset($_GET['price'])&& !empty($_GET['price'])){
                            $prices = explode('~',$_GET['price']);
                            if(!empty($prices)&&in_array($price,$prices)){
                                $pricechecked = 'checked';
                            }else{
                                $pricechecked = '';
                            }

                         }else{
                            $pricechecked = ''; 
                         }
                        ?>
                        <li>
                            <!--====== Check Box ======-->
                            <div class="check-box">
                                <input type="checkbox" id="price{{$key}}" name="price" value="{{$price}}" class="filterAjax" {{$pricechecked}}>
                                <div class="check-box__state check-box__state--primary">
                                    <label class="check-box__label" for="price{{$key}}">{{$price}}</label>
                                </div>
                            </div>
                            <!--====== End - Check Box ======-->
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="u-s-m-b-30">
            <div class="shop-w shop-w--style">
                <div class="shop-w__intro-wrap">
                    <h1 class="shop-w__h">COLOR</h1>

                    <span class="fas fa-minus shop-w__toggle" data-target="#s-color" data-toggle="collapse"></span>
                </div>
                <div class="shop-w__wrap collapse show" id="s-color">
                    <?php
                    $getColors = ProductsFilter::getColors($categoryDetails['catIds']);
                    ?>
                    <ul class="shop-w__list gl-scroll">
                        @foreach($getColors as $key => $color)
                        <?php 
                         if(isset($_GET['color'])&& !empty($_GET['color'])){
                            $colors = explode('~',$_GET['color']);
                            if(!empty($colors)&&in_array($color,$colors)){
                                $colorchecked = 'checked';
                            }else{
                                $colorchecked = '';
                            }

                         }else{
                            $colorchecked = ''; 
                         }
                        ?>
                        <li>
                            <div class="color__check">
                                <input type="checkbox" id="color{{$key}}" name="color" value="{{$color}}" class="filterAjax" {{$colorchecked}}>
                                <label class="color__check-label" for="color{{$key}}" style="background-color: {{ $color }}" title="{{$color}}"></label>
                            </div>{{$color}}
                        </li>   
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <?php
        $getDynamicFilters = ProductsFilter::getDynamicFilters($categoryDetails['catIds']);
        ?>
        @foreach($getDynamicFilters as $key => $filter)
        <div class="u-s-m-b-30">
            <div class="shop-w shop-w--style">
                <div class="shop-w__intro-wrap">
                    <h1 class="shop-w__h">{{ucwords($filter)}}</h1>

                    <span class="fas fa-minus shop-w__toggle" data-target="#s-filter{{$key}}" data-toggle="collapse"></span>
                </div>
                <div class="shop-w__wrap collapse show" id="s-filter{{$key}}">
                    <ul class="shop-w__list gl-scroll">
                        <?php
                        $filterValues = ProductsFilter::selectedfilters($filter,$categoryDetails['catIds']);
                        ?>
                        @foreach( $filterValues as $fkey => $filterValue) 
                        @php $checkFilter = "" @endphp
                        @if(isset($_GET[$filter]))
                            @php $explodeFilters = explode('~',$_GET[$filter]); @endphp
                            @if(in_array($filterValue,$explodeFilters))
                                @php $checkFilter = 'checked' @endphp
                            @endif
                        @endif
                        <li>

                            <!--====== Check Box ======-->
                            <div class="check-box">

                                <input type="checkbox" id="filter{{$fkey}}" name="{{$filter}}" value="{{$filterValue}}" class="filterAjax" {{$checkFilter}}>
                                <div class="check-box__state check-box__state--primary">

                                    <label class="check-box__label" for="filter{{$fkey}}">{{$filterValue}}</label></div>
                            </div>
                            <!--====== End - Check Box ======-->
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>