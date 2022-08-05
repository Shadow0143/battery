@extends('admin.layout.app')
@section('title')
    Admin | Item Add
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Item</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Item</li>
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
            <h3 class="card-title">Add Item</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('admin.product.add')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Code</label>
                <input type="text" class="form-control" placeholder="Please Enter Product Code" name="code" value="{{ old('code') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name *</label>
                <input type="text" class="form-control" placeholder="Please Enter Product Name" name="name" value="{{ old('name') }}" required>
              </div>
            </div>
            <div class="card-body">
                <div class="form-group col-lg-6">
                  <label for="exampleInputEmail1">Opening Balance</label>
                  <input type="number" class="form-control" placeholder="Please Enter Opening Balance" name="opening_balence" value="{{ old('opening_balence') }}">
                </div>
              </div>
           <?php /* <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Category *</label>
                <select  class="form-control" name="ref_category" required>
				        	<option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>  
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Brand  *</label>
                <select class="form-control" name="ref_brand" required>
                <option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($brands as $brand)
                  <option value="{{$brand->id}}">{{$brand->name}}</option>
                  @endforeach
                </select>
              </div>
            </div> */ ?>
            <!-- /.card-body -->

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
