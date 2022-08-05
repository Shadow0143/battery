@extends('admin.layout.app')
@section('title')
    Admin | Customer Edit
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Edit Customer</li>
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
            <h3 class="card-title">Edit Customer</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('admin.customer.edit',$item->id)}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card-body row">

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Name *</label>
                <input type="text" class="form-control" placeholder="Please Enter Customer Name" name="name" value="{{ $item->name }}">
              </div>
           
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Type *</label>
                <select  class="form-control" name="type" required>
                  <option value="">-- select one --</option>           
                  <option value="1" <?php if($item->type==1) echo 'selected'; ?>>Dealer</option>
                  <option value="2" <?php if($item->type==2) echo 'selected'; ?>>Customer</option>       
                </select>
              </div>
           
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Phone Number</label>
                <input type="number" class="form-control" placeholder="Please Enter Phone Number" name="phone" value="{{ $item->phone }}">
              </div>
           
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Email Address</label>
                <input type="email" class="form-control" placeholder="Please Enter Email Address" name="email" value="{{ $item->email }}">
              </div>
           
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Address</label>
                <textarea name="address" class="form-control" rows="4" cols="30" placeholder="Please Enter Customer Address">{{ $item->address }}</textarea>
              </div>

            </div>

         
         <?php /*   <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Company Name</label>
                <input type="text" class="form-control" placeholder="Please Enter Company Name" name="company_name" value="{{ $item->company_name }}">
              </div>
            </div>

            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">City</label>
                <input type="text" class="form-control" placeholder="Please Enter City Name" name="city" value="{{ $item->city }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">State</label>
                <input type="text" class="form-control" placeholder="Please Enter State Name" name="state" value="{{ $item->state }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Country</label>
                <input type="text" class="form-control" placeholder="Please Enter Country Name" name="country" value="{{ $item->country }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">PIN</label>
                <input type="number" class="form-control" placeholder="Please Enter PIN Number" name="pin" value="{{ $item->pin }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">GST Number</label>
                <input type="text" class="form-control" placeholder="Please Enter GST Number" name="gst" value="{{ $item->gst }}">
              </div>
            </div> */ ?>

            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('admin.customer.view')}}" class="btn btn-primary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop
