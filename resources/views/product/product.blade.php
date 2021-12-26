@extends('index')

@section('css')

    <style>
        label {
            font-weight: bolder;
        }

        legend {
            font-weight: bolder;
        }
    </style>

@endsection
@section('content')
    <div class="container-fluid mt-3">
        {{--<form id="{{isset($product) ? "updateProduct" : "createProduct"}}"--}}
        <form method="post" action="{{!isset($product) ? route('store') : route('edit',[$product[0]->id])}}"
              enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> {{Session::get('success')}}
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="hidden" name="product_id"
                                   value="{{isset($product[0]->id) ? $product[0]->id : "" }}">
                            <label for="category">Category</label>
                            <select id="category" class="form-control" onchange="getSubcategories(this.value)"
                                    name="category">
                                <option selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option {{(isset($product[0]->subcategory) &&
                                            $product[0]->subcategory->category->id == $category->id)
                                            ? 'selected' : '' }}
                                            value={{$category->id}}
                                            {{old('category') == $category->id ? 'selected':""}}>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="subcategory">Subcategory</label>
                            <select id="subcategory" class="form-control" name="subcategory">
                                {{--old not working for dynamically create dropdown--}}
                                <option value="{{isset($product[0]->subcategory) ?
                                $product[0]->subcategory->id: old('subcategory') }}">
                                    {{isset($product[0]->subcategory) ?
                                    $product[0]->subcategory->name: 'Select Subcategory'}}
                                </option>

                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pro_name">Product Name</label>
                            <input type="text" class="form-control" id="pro_name" placeholder="Product Name"
                                   value="{{isset($product[0]->name) ? $product[0]->name : old('pro_name')}}"
                                   name="pro_name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="sale_date_before">Sale Date Before</label>
                            <input type="date" class="form-control" id="sale_date_before"
                                   value="{{isset($product[0]->sale_date_before) ?
                                   $product[0]->sale_date_before : old('sale_date_before')}}" name="sale_date_before">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pro_price">Product Price</label>
                            <input type="range" min=100 max=1000 step="10" class="custom-range" id="pro_price"
                                   value="{{isset($product[0]->price) ? $product[0]->price : ""}}">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="text" id="showPrice" name="pro_price"
                                   value="{{isset($product[0]->price) ? $product[0]->price : old('pro_price')}}"
                                   readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="pro_description">Product Description</label>
                            <textarea class="form-control" id="pro_description" rows="3" name="pro_description"
                                      style="resize: none;">
                                {{isset($product[0]->description) ? $product[0]->description : old('pro_description')}}
                            </textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="File1">Choose File 1</label>
                            <input type="file" class="form-control-file"
                                   onchange="previewImage(this)"
                                   name="pro_image"
                                   id="File1">
                        </div>
                        <div class="col-md-2 mb-3">
                            <img src="{{isset($product[0]->image) ?
                            asset('/images/'.$product[0]->image) : asset('/images/nophoto.png')}}"
                                 id="imagePreview" alt="Product Image"
                                 height="80px" width="100px">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-6 mb-3">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-md-4 float-md-left pt-0">Product Colors</legend>
                                <div class="col-md-8" id="pro_colors">
                                    <div class="row">
                                        @foreach($colors as $colorChuncks)
                                            <div class="col-md-4">
                                                @foreach($colorChuncks as $color)
                                                    <div class="form-check">
                                                        <input class="form-check-input enable-color-quantity"
                                                               type="checkbox" name="colors[]"
                                                               {{isset($product[0]->colors) &&
                                                               $product[0]->colors->contains($color->id)
                                                               ? 'checked' : ''}}
                                                               {{!isset($product[0]->colors) ?
                                                               (is_array(old('colors')) &&
                                                               in_array($color->id, old('colors')) ? 'checked' : '')
                                                               : '' }}
                                                               value="{{$color->id}}">
                                                        <span class="form-check-label">
                                                            {{$color->name}}
                                                        </span>
                                                        <input id="qty-{{$color->id}}"
                                                               type="text" name="color-quantity-[{{$color->id}}]"
                                                               class="form-control color-quantity"
                                                               disabled
                                                               style="height: 25px">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 mb-3">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-sm-4 float-sm-left pt-0">Product Sizes</legend>
                                <div class="col-sm-8">
                                    @foreach($sizes as $size)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sizes[]"
                                                   id="{{$size->id}}"
                                                   @if(isset($product[0]->sizes) &&
                                                   $product[0]->sizes->contains($size->id))
                                                   checked
                                                   @elseif(!isset($product[0]->sizes) &&
                                                   is_array(old('sizes')) && in_array($size->id, old('sizes')))
                                                   checked
                                                   @endif
                                                   value="{{$size->id}}">
                                            <span class="form-check-label" for="small">
                                                {{$size->name}}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-sm-4 float-sm-left pt-0">Product Quality</legend>
                                <div class="col-sm-8">
                                    @foreach($qualities as $quality)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pro_quality"
                                                   id="{{$quality->id}}"
                                                   @if(isset($product[0]->quality) &&
                                                   $product[0]->quality->id == $quality->id)
                                                   checked
                                                   @elseif(!isset($product[0]->quality) &&
                                                   (old('pro_quality') == $quality->id))
                                                   checked
                                                   @endif
                                                   value="{{$quality->id}}">
                                            <span class="form-check-label" for="high">
                                                {{$quality->name}}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 mb-3">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-sm-4 float-sm-left pt-0">Product Fabric</legend>
                                <div class="col-sm-8">
                                    <div class="row">
                                        @foreach ($fabrics as $fabricChunks)
                                            <div class="col-md-4">
                                                @foreach($fabricChunks as $fabric)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pro_fabric"
                                                               id="{{$fabric->id}}"
                                                               @if(isset($product[0]->fabric) &&
                                                               $product[0]->fabric->id == $fabric->id)
                                                               checked
                                                               @elseif(!isset($product[0]->fabric) &&
                                                               (old('pro_fabric') == $fabric->id))
                                                               checked
                                                               @endif
                                                               value="{{$fabric->id}}">
                                                        <span class="form-check-label" for="cotton">
                                                            {{$fabric->name}}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div>
                        @if(isset($product))
                            <button class="btn btn-warning" type="submit">Update Product</button>
                        @else
                            <button class="btn btn-primary" type="submit">Create Product</button>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    @if(Session::has('failed'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed!</strong> {{Session::get('failed')}}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

        });

        function getSubcategories(category_id) {
            $.ajax({
                type: 'GET',
                url: '{{ route('subcategories') }}',
                data: {
                    'id': category_id
                },
                success: function (response) {
                    let data = response.data[0].subcategories;
                    let template = '<option value="default">Select Subcategory</option>';
                    for (let i = 0; i < data.length; i++) {
                        template += '<option value="' + data[i].id + '" id="' + data[i].id + '"> ' +
                            data[i].name + '</option>';
                    }
                    $('#subcategory').html(template);
                },
            });
        }

        $('.enable-color-quantity').on('click',function () {
            let id = $(this).val();
            let enabled = $(this).is(':checked');
            $('#qty-'+id).attr('disabled',!enabled);
            $('#qty-'+id).val(null)
            // alert(enabled);
        });

        $('#pro_price').on('input', function () {
            $('#showPrice').val($(this).val())
        });

        function previewImage(input) {
            let file = $("input[type=file]").get(0).files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function () {
                    $('#imagePreview').attr('src', reader.result)
                };
                reader.readAsDataURL(file);
            }
        }

        $('#createProduct').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '/product/store',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response.data)
                    window.location.href = "{{route('index')}}"
                }
            });
        });

        $('#updateProduct').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '/product/update',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    window.location.href = "{{route('index')}}"
                }
            });
        });

    </script>
@endsection