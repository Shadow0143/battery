@extends('admin.layout.app')
@section('title')
    Admin | Stock Edit
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Stock Edit</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Stock Edit</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@include('admin.layout.alert')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Stock Edit</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form" action="{{route('admin.edit-stock.add',$stock_details_id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <?php
            $products=App\Models\Product::get()
            ?>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Product *</label>
                <select  class="form-control product select2" name="ref_product" required>
                    <option value="" selected="selected" disabled="disabled">-- select one Product--</option>
                    @foreach($products as $product)
                    <option value="{{$product->id}}" >{{$product->name}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Quantity *</label>
                  <input type="number" class="form-control" placeholder="Please Enter Quantity" name="quantity" value="{{ old('quantity') }}">
                </div>
              </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('admin.stock.view')}}" class="btn btn-primary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>

<script>
    $('.select2').select2();
</script>

<style type="text/css">
  label.error { color: red }
  .select2-container .select2-selection--single{height: 39px;border: 1px solid #ced4da;}
  .select2-container--default .select2-selection--single .select2-selection__arrow{height:100%;}
</style>

@stop
