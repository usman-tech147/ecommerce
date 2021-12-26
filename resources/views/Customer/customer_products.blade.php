@extends('index')
@section('content')

    <div style="width: 95%; margin:auto;">
        {{--<form action="">--}}
        {{--@csrf--}}
        <div class="row">
            <div class="col-md-3">
                <div class="input-group mt-3 mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button">Product Name</button>
                    </div>
                    <input type="text" class="form-control" placeholder="" aria-label=""
                           aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mt-3 mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button">Product Max Price</button>
                    </div>
                    <input type="number" class="form-control" placeholder="" aria-label=""
                           aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mt-3 mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button">Product Min Price</button>
                    </div>
                    <input type="number" class="form-control" placeholder="" aria-label=""
                           aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <select id="category" class="form-control" name="category">
                    <option selected>Select Category</option>
                    @foreach($categories as $category)
                        <option value={{$category->id}}> {{$category->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <form id="productsFilter">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-md-8 float-md-left pt-0"><h3>Colors</h3></legend>
                                @foreach($colors as $color)
                                    <div class="col-md-8" id="pro_colors">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]"
                                                   value="{{$color->id}}">
                                            <label class="form-check-label" for="yellow">
                                                {{$color->name}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-md-8 float-md-left pt-0"><h3>Sizes</h3></legend>
                                <div class="col-md-8" id="pro_sizes">
                                    @foreach ($sizes as $size)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sizes[]"
                                                   value="{{$size->id}}">
                                            <label class="form-check-label">
                                                {{$size->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-md-8 float-md-left pt-0"><h3> Quality </h3></legend>
                                <div class="col-md-8" id="pro_qualities">
                                    @foreach ($qualities as $quality)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="qualities[]"
                                                   value="{{$quality->id}}">
                                            <label class="form-check-label" for="yellow">
                                                {{$quality->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="form-group row">
                                <legend class="col-form-label col-md-8 float-md-left pt-0"><h3> Fabric </h3></legend>
                                <div class="col-md-8" id="pro_colors">
                                    @foreach ($fabrics as $fabric)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fabrics[]"
                                                   value="{{$fabric->id}}">
                                            <label class="form-check-label" for="yellow">
                                                {{$fabric->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <button class="btn btn-primary"> Apply Filters</button>
                </form>
            </div>

            <div class="col-md-8 offset-md-1" id="productsData">
                @foreach($products->chunk(3) as $productChunk)
                    <div class="card-deck mb-3 mt-3 row">
                        @foreach($productChunk as $product)
                            <div class="card col-md-4">
                                <img class="card-img-top" src="{{asset('/images/'.$product->image)}}"
                                     width="90" height="150"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title"><strong> Name: </strong> {{$product->name}}</h5>
                                    <p class="card-text">
                                        <strong> Colors: </strong>
                                        @foreach($product->colors as $color)
                                            {{$color->name}},
                                        @endforeach
                                        <br>
                                        <strong> Sizes: </strong>
                                        @foreach($product->sizes as $size)
                                            {{$size->name}},
                                        @endforeach
                                        <br>
                                        <strong> Quality: </strong>
                                        {{$product->quality->name}}
                                        <br>
                                        <strong> Fabric: </strong>
                                        {{$product->fabric->name}}
                                        <br>
                                        <strong> Description: </strong>
                                        {{$product->description}} <br>
                                        <strong>Category: </strong>
                                        {{$product->subcategory->category->name}}<br>
                                        <strong>Subcategory: </strong>
                                        {{$product->subcategory->name}}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <label class="text-muted"><strong> Price: </strong>{{$product->price}}</label>
                                    <button class="btn btn-sm btn-warning float-right"> Add To Cart</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                {{--{{$products->links()}}--}}
            </div>
        </div>
        {{--</form>--}}
    </div>

@endsection

@section('js')
    <script>
        // $(document).ready(function (e) {
        //     alert('working')
        // })

        $('#productsFilter').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(document.getElementById('productsFilter'));


            $.ajax({
                type: 'POST',
                url: '/customer/filter-product',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    $('#productsData').html(response.data);
                    // console.log(response.data)
                }

            });
        })
    </script>
@endsection