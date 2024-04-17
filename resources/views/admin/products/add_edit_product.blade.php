@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{ $title}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{ $title}}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-12">
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              @endif
              <form name="productForm" id="productForm" @if(empty($product['id'])) action="{{ url('admin/add-edit-product')}}" 
              @else action="{{ url('admin/add-edit-product/'.$product['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_id">Select Category*</label>
                    <select name="category_id" class="form-control">
                      <option value="">Select</option>
                      @foreach($getCategories as $cat)
                        <option @if(!empty(@old('category_id')) && $cat['id']==@old('category_id')) selected="" @elseif(!empty($product['category_id']) 
                        && $product['category_id'] == $cat['id']) selected="" @endif value="{{ $cat['id'] }}">{{ $cat['category_name'] }}</option>
                          @if(!empty($cat['subcategories']))
                            @foreach($cat['subcategories'] as $subcat)
                              <option @if(!empty(@old('category_id')) && $subcat['id']==@old('category_id')) selected="" @elseif(!empty($product['category_id']) 
                              && $product['category_id'] == $subcat['id']) selected="" @endif value="{{ $subcat['id'] }}">
                              &nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subcat['category_name'] }}</option>
                                @if(!empty($subcat['subcategories']))
                                  @foreach($subcat['subcategories'] as $subsubcat)
                                    <option @if(!empty(@old('category_id')) && $subsubcat['id']==@old('category_id')) selected="" @elseif(!empty($product['category_id']) 
                                    && $product['category_id'] == $subsubcat['id']) selected="" @endif value="{{ $subsubcat['id'] }}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo;
                                    {{ $subsubcat['category_name'] }}</option>
                                  @endforeach
                                @endif
                            @endforeach
                          @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" 
                    @if(!empty($product['product_name'])) value= "{{ $product['product_name'] }}" @else value="{{ @old('product_name') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_code">Product Code</label>
                    <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter Product Code"
                    @if(!empty($product['product_code'])) value= "{{ $product['product_code'] }}" @else value="{{ @old('product_code') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_color">Product Color</label>
                    <input type="text" class="form-control" id="product_color" name="product_color" placeholder="Enter Product Color"
                    @if(!empty($product['product_color'])) value= "{{ $product['product_color'] }}" @else value="{{ @old('product_color') }}" @endif>
                  </div>
                  @php $familyColors = \App\Models\Color::colors() @endphp
                  <div class="form-group">
                    <label for="family_color">Family Color</label>
                    <select name="family_color" class="form-control">
                    <option value="">Select</option>
                    @foreach($familyColors as $color)
                    <option value={{ $color['color_name'] }} @if(!empty(@old('family_color')) && @old('family_color') == $color['color_name'])) selected="" @elseif(!empty($product['family_color']) 
                    && $product['family_color'] == $color['color_name']) selected="" @endif>{{ $color['color_name'] }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="group_code">Group code</label>
                    <input type="text" class="form-control" id="group_code" name="group_code" placeholder="Enter Group code"
                    @if(!empty($product['group_code'])) value= "{{ $product['group_code'] }}" @else value="{{ @old('group_code') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price"
                    @if(!empty($product['product_price'])) value= "{{ $product['product_price'] }}" @else value="{{ @old('product_price') }}" @endif required="">
                  </div>
                  <div class="form-group">
                    <label for="product_discount">Product Discount (%)</label>
                    <input type="text" class="form-control" id="product_discount" name="product_discount" placeholder="Enter Product Discount (%)"
                    @if(!empty($product['product_discount'])) value= "{{ $product['product_discount'] }}" @else value="{{ @old('product_discount') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_weight">Product Weight</label>
                    <input type="text" class="form-control" id="product_weight" name="product_weight" placeholder="Enter Product Weight"
                    @if(!empty($product['product_weight'])) value= "{{ $product['product_weight'] }}" @else value="{{ @old('product_weight') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_video">Product Video</label>
                    <input type="file" class="form-control" id="product_video" name="product_video">
                    @if(!empty($product['product_video']))
                    <a target="_blank" href="{{ url('front/videos/products/'.$product['product_video']) }}">View</a>&nbsp;&nbsp; | &nbsp;&nbsp;
                    <a class="confirmDelete" title="Delete Product Video"  href="javascript:void(0)" record="product-video" 
                    recordid="{{ $product['id']}}"> Delete </a>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="material">Material</label>
                    <select name="material" class="form-control">
                    <option value="">Select</option>
                    @foreach($productsFilters['materialArray'] as $material)
                      <option value="{{ $material }}" @if(!empty(@old('material')) && @old('material')== $material)) selected="" @elseif(!empty($product['material']) 
                    && $product['material'] == $material) selected="" @endif>{{ $material }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="size">Size</label>
                    <select name="size" class="form-control">
                    <option value="">Select</option>
                    @foreach($productsFilters['sizeArray'] as $size)
                      <option value="{{ $size }}" @if(!empty(@old('size')) && @old('size')== $size)) selected="" @elseif(!empty($product['size']) 
                    && $product['size'] == $size) selected="" @endif>{{ $size }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="layers">Layers</label>
                    <select name="layers" class="form-control">
                    <option value="">Select</option>
                    @foreach($productsFilters['layersArray'] as $layers)
                      <option value="{{ $layers }}" @if(!empty(@old('layers')) && @old('layers')== $layers)) selected="" @elseif(!empty($product['layers']) 
                    && $product['layers'] == $layers) selected="" @endif>{{ $layers }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="shape">Shape</label>
                    <select name="shape" class="form-control">
                    <option value="">Select</option>
                    @foreach($productsFilters['shapeArray'] as $shape)
                      <option value="{{ $shape }}" @if(!empty(@old('shape')) && @old('shape')== $shape)) selected="" @elseif(!empty($product['shape']) 
                    && $product['shape'] == $shape) selected="" @endif>{{ $shape }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="pieces">Pieces</label>
                    <select name="pieces" class="form-control">
                    <option value="">Select</option>
                    @foreach($productsFilters['piecesArray'] as $pieces)
                      <option value="{{ $pieces }}" @if(!empty(@old('pieces')) && @old('pieces')== $pieces)) selected="" @elseif(!empty($product['pieces']) 
                    && $product['pieces'] == $pieces) selected="" @endif>{{ $pieces }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Product Description">
                    @if(!empty($product['description'])) {{ $product['description'] }} @else {{ @old('description') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="search_keywords">Search Keywords</label>
                    <textarea class="form-control" rows="3" id="search_keywords" name="search_keywords" placeholder="Enter Product Search Keywords">
                    @if(!empty($product['search_keywords'])) {{ $product['search_keywords'] }} @else {{ @old('search_keywords') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title"
                    @if(!empty($product['meta_title'])) value= "{{ $product['meta_title'] }}" @else value="{{ @old('meta_title') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description"
                    @if(!empty($product['meta_description'])) value= "{{ $product['meta_description'] }}" @else value="{{ @old('meta_description') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="c">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Meta Keywords"
                    @if(!empty($product['meta_description'])) value= "{{ $product['meta_description'] }}" @else value="{{ @old('meta_description') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="is_featured">Featured Item</label>
                    <input type="checkbox" name="is_featured" value="Yes" @if(!empty($product['is_featured']) && $product['is_featured'] == "Yes") checked="" @endif>
                  </div>
                </div>
                <!-- /.card-body -->

                <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection