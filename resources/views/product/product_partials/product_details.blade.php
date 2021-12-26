<div style="overflow: auto; overflow-x: hidden; height: 600px; width: 800px;">
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <input type="hidden" name="product_id" value="@if(isset($product['id'])) {{$product['id'] }} @endif">
            <label for="category">Category</label>
            <select id="category" class="form-control" onchange="getSubcategories(this.value)" name="category">
                <option selected>Select Category</option>
                @foreach($categories as $category)
                    <option @if(isset($product['category']) and $product['category'] == $category->id) selected
                            @endif value={{$category->id}}> {{$category->name}} </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="subcategory">Subcategory</label>
            <select id="subcategory" class="form-control" name="subcategory">
                @if(isset($product['subcategory_id']))
                    <option value="{{$product['subcategory_id']}}" selected>
                        {{$product['subcategory_name']}}
                    </option>
                @else
                    <option selected>
                        Select Subcategory
                    </option>
                @endif
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="pro_name">Product Name</label>
            <input type="text" class="form-control" id="pro_name"
                   @if(isset($product['name'])) value="{{$product['name']}}" @endif
                   name="pro_name">
        </div>
        <div class="col-md-6 mb-3">
            <label for="added_date">Added Date</label>
            <input type="date" class="form-control" id="added_date"
                   @if(isset($product['added_date'])) value="{{$product['added_date']}}" @endif
                   name="added_date">
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="pro_price">Product Price</label>
            <input type="range" min=100 max=1000 class="custom-range" id="pro_price" name="pro_price"
                   @if(isset($product['price'])) value="{{$product['price']}}" @endif
                   onchange="price()">
        </div>
        <div class="col-md-6 mt-4">
            <input type="text" id="showPrice"
                   @if(isset($product['price'])) value="{{$product['price']}}" @endif
                   readonly class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="pro_description">Product Description</label>
        <textarea class="form-control" id="pro_description" rows="3" name="pro_description"
                  style="resize: none;"> @if(isset($product['description'])) {{$product['description']}} @endif </textarea>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <fieldset class="form-group row">
                <legend class="col-form-label col-md-4 float-md-left pt-0">Product Colors</legend>
                <div class="col-md-8" id="pro_colors">
                    @foreach($colors as $color)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="colors[]" id="{{$color->id}}"
                                   @if(isset($product['colors']) and in_array($color->id,$product['colors'])) checked
                                   @endif
                                   value="{{$color->id}}">
                            <label class="form-check-label" for="yellow">
                                {{$color->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        </div>
        <div class="col-md-6 mb-3">
            <fieldset class="form-group row">
                <legend class="col-form-label col-sm-4 float-sm-left pt-0">Product Sizes</legend>
                <div class="col-sm-8">
                    @foreach($sizes as $size)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sizes[]" id="{{$size->id}}"
                                   @if(isset($product['sizes']) and in_array($size->id,$product['sizes'])) checked
                                   @endif
                                   value="{{$size->id}}">
                            <label class="form-check-label" for="small">
                                {{$size->name}}
                            </label>
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
                            <input class="form-check-input" type="radio" name="pro_quality" id="{{$quality->id}}"
                                   @if(isset($product['quality']) and $product['quality'] == $quality->id) checked
                                   @endif
                                   value="{{$quality->id}}">
                            <label class="form-check-label" for="high">
                                {{$quality->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        </div>
        <div class="col-md-6 mb-3">
            <fieldset class="form-group row">
                <legend class="col-form-label col-sm-4 float-sm-left pt-0">Product Fabric</legend>
                <div class="col-sm-8">
                    @foreach ($fabrics as $fabric)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pro_fabric" id="{{$fabric->id}}"
                                   @if(isset($product['fabric']) and $product['fabric'] == $fabric->id) checked @endif
                                   value="{{$fabric->id}}">
                            <label class="form-check-label" for="cotton">
                                {{$fabric->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="File1">Choose File 1</label>
            <input type="file" class="form-control-file"
                   onchange="previewImage(this)"
                   name="pro_image"
                   id="File1">
        </div>
        <img @if(isset($product))
             src="{{asset('/images/'.$product['image'])}}"
             @else
             src="{{asset('/images/nophoto.png')}}"
             @endif
             id="imagePreview" alt="Product Image"
             height="150px" width="120px">

    </div>
    <div>
        @if(isset($product))
            <button class="btn btn-warning" type="submit">Update Product</button>
        @else
            <button class="btn btn-primary" type="submit">Create Product</button>
        @endif
    </div>
</div>

