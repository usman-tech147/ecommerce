<div>
    <div class="form-group" style="margin:30px">
        <label for="File1">Choose File 1</label>
        <input type="file" class="form-control-file" name="pro_files[]" id="File1">
    </div>
    <div class="form-group" style="margin:30px">
        <label for="File1">Choose File 2</label>
        <input type="file" class="form-control-file" name="pro_files[]" id="File1">
    </div>
    <div class="form-group" style="margin:30px">
        <label for="File1">Choose File 3</label>
        <input type="file" class="form-control-file" name="pro_files[]" id="File1">
    </div>
    <div class="form-group" style="margin:30px">
        <label for="File1">Choose File 4</label>
        <input type="file" class="form-control-file" name="pro_files[]" id="File1">
    </div>
</div>

<div style="margin-left: 30px">
    @if(isset($product))
        <button class="btn btn-primary" type="submit">Create Product</button>
    @else
        <button class="btn btn-primary" type="submit">Update Product</button>
    @endif
</div>
