@extends('index')

@section('content')
    <div class="container mt-3">
        <div>
            <a class="btn btn-success float-right mb-3" href="{{ route('create') }}">
                Add Product
            </a>
        </div>
        {{--<table class="table" id="products_table">--}}
            {{--<thead class="thead-dark">--}}
            {{--<tr>--}}
                {{--<th scope="col">#</th>--}}
                {{--<th scope="col">Product</th>--}}
                {{--<th scope="col">Price</th>--}}
                {{--<th scope="col">Subcategory</th>--}}
                {{--<th scope="col">Status</th>--}}
                {{--<th scope="col">Image</th>--}}
                {{--<th scope="col">Actions</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach ($products as $product)--}}
                {{--<tr>--}}
                    {{--<th scope="row">{{$product['id']}}</th>--}}
                    {{--<td>{{$product['name']}}</td>--}}
                    {{--<td>{{$product['price']}}</td>--}}
                    {{--<td>{{$product['subcategory']['name']}}</td>--}}
                    {{--<td>{{$product['status']}}</td>--}}
                    {{--<td>--}}
                        {{--<img src="{{asset('/images/'.$product['image'])}}"--}}
                             {{--alt="" height="50px" width="50px">--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="btn-group btn-group-sm" role="group" aria-label="...">--}}
                            {{--<a class="btn btn-primary" href="#"> view</a>--}}
                            {{--<form id="deleteProduct{{$product['id']}}" role="form" style="display: none">--}}
                                {{--@csrf--}}
                                {{--<input type="hidden" name="product_id" value="{{$product['id']}}">--}}
                            {{--</form>--}}
                            {{--<a class="btn btn-danger" href="#" onclick="deleteProduct({!! $product['id'] !!})">--}}
                                {{--Delete</a>--}}
                            {{--<a class="btn btn-warning" href="{{route('edit',$product['id'])}}"> Edit </a>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    </div>
@endsection

@section('js')
    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });


        {{--$(document).ready(function () {--}}

            {{--$('#products_table').DataTable({--}}
                {{--processing: true,--}}
                {{--serverside: true,--}}
                {{--'ajax': {--}}
                    {{--"url": '{{route('get-all-products')}}',--}}
                    {{--"type": 'POST',--}}
                    {{--data: function (d) {--}}
                        {{--d.CSRF = '{{csrf_token()}}';--}}
                    {{--},--}}
                    {{--// "dataSrc": function (json) {--}}
                    {{--//     console.log(json);--}}
                    {{--//     return json;--}}
                    {{--// }--}}
                {{--},--}}
                {{--columns: [--}}
                    {{--{--}}
                        {{--data: 'id',--}}
                    {{--},--}}
                    {{--{--}}
                        {{--data: 'Product_no',--}}
                    {{--},--}}
                    {{--{--}}
                        {{--data: 'name',--}}
                    {{--},--}}
                    {{--{--}}
                        {{--data: 'length',--}}
                    {{--},--}}
                    {{--{--}}
                        {{--data: 'album',--}}
                        {{--orderable: false,--}}
                        {{--searchable: false--}}
                    {{--},--}}
                {{--],--}}
                {{--// columnDefs: [--}}
                {{--//     {orderable: false, targets: [0, 4, 5, 6]},--}}
                {{--//     {searchable: false, targets: [0, 4, 5, 6]}--}}
                {{--// ],--}}
            {{--});--}}
        {{--});--}}

        function deleteProduct(id) {
            let formData = new FormData(document.getElementById('deleteProduct' + id));
            $.ajax({
                type: "POST",
                url: "{{route('product.delete')}}",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    window.location.href = "{{route('index')}}"
                }
            })
        }
    </script>
@endsection


{{--<tbody>--}}
{{--@foreach ($products as $product)--}}
    {{--<tr>--}}
        {{--<th scope="row">{{$product['id']}}</th>--}}
        {{--<td>{{$product['name']}}</td>--}}
        {{--<td>{{$product['price']}}</td>--}}
        {{--<td>{{$product['subcategory']['name']}}</td>--}}
        {{--<td>{{$product['status']}}</td>--}}
        {{--<td>--}}
            {{--<img src="{{asset('/images/'.$product['image'])}}"--}}
                 {{--alt="" height="50px" width="50px">--}}
        {{--</td>--}}
        {{--<td>--}}
            {{--<div class="btn-group btn-group-sm" role="group" aria-label="...">--}}
                {{--<a class="btn btn-primary" href="#"> view</a>--}}
                {{--<form id="deleteProduct{{$product['id']}}" role="form" style="display: none">--}}
                    {{--@csrf--}}
                    {{--<input type="hidden" name="product_id" value="{{$product['id']}}">--}}
                {{--</form>--}}
                {{--<a class="btn btn-danger" href="#" onclick="deleteProduct({!! $product['id'] !!})">--}}
                    {{--Delete</a>--}}
                {{--<a class="btn btn-warning" href="{{route('edit',$product['id'])}}"> Edit </a>--}}
            {{--</div>--}}
        {{--</td>--}}
    {{--</tr>--}}
{{--@endforeach--}}
{{--</tbody>--}}