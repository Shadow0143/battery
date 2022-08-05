@extends('admin.layout.app')
@section('title')
    Admin | Item Edit
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Item</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Edit Item</li>
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
            <h3 class="card-title">Edit Item</h3>
          </div>
          <form role="form"  action="{{route('admin.product.edit',$item->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Code</label>
                <input type="text" class="form-control" placeholder="Please Enter Product Code" name="code" value="{{ $item->code }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name *</label>
                <input type="text" class="form-control" placeholder="Please Enter Product Name" name="name" value="{{ $item->name }}" required>
              </div>
            </div>

          <?php $stocksSearch = DB::table('stocks')->where('ref_product','=',$item->id)->pluck('id')->first(); 
            $order_detailsSearch = DB::table('order_details')->where('ref_product','=',$item->id)->pluck('id')->first();
          ?>

            <div class="card-body">
                <div class="form-group col-lg-6">
                  <label for="exampleInputEmail1">Opening Balance</label>
                  <input type="hidden" name="oldbalence" value="{{ $item->opening_balence }}">
                  <input type="number" class="form-control" placeholder="Please Enter Opening Balance" name="opening_balence" value="{{ $item->opening_balence }}" @if(!empty($stocksSearch) || !empty($order_detailsSearch)) style="background-color: #ffffff;" readonly="true" @endif >
                </div>
              </div>

          <?php /*  <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Category *</label>
                <select  class="form-control" name="ref_category" required>
                <option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}" {{ (isset($item)&&$item->ref_category == $category->id)?'selected':''}}>{{$category->name}}</option>
                  @endforeach
                    </select>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Brand *</label>
                <select class="form-control" name="ref_brand" required>
                  <option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($brands as $brand)
                  <option value="{{$brand->id}}" {{ (isset($item)&&$item->ref_brand == $brand->id)?'selected':''}}>{{$brand->name}}</option>
                  @endforeach
                </select>
              </div>
            </div> */ ?>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('admin.product.view')}}" class="btn btn-primary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop
