@extends('employee.layout.app')
@section('title')
    Employee | Customer Add
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('employee.employee-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Customer</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@include('employee.layout.alert')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add Customer</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('employee.customer.add')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name *</label>
                <input type="text" class="form-control" placeholder="Please Enter Customer Name" name="name" value="{{ old('name') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Company Name</label>
                <input type="text" class="form-control" placeholder="Please Enter Company Name" name="company_name" value="{{ old('company_name') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Phone Number</label>
                <input type="number" class="form-control" placeholder="Please Enter Phone Number" name="phone" value="{{ old('phone') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Email Address</label>
                <input type="email" class="form-control" placeholder="Please Enter Email Address" name="email" value="{{ old('email') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">City</label>
                <input type="text" class="form-control" placeholder="Please Enter City Name" name="city" value="{{ old('city') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">State</label>
                <input type="text" class="form-control" placeholder="Please Enter State Name" name="state" value="{{ old('state') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Country</label>
                <input type="text" class="form-control" placeholder="Please Enter Country Name" name="country" value="{{ old('country') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">PIN</label>
                <input type="number" class="form-control" placeholder="Please Enter PIN Number" name="pin" value="{{ old('pin') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Address</label>
                <textarea name="address" class="form-control" placeholder="Please Enter Customer Address"></textarea>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">GST Number</label>
                <input type="text" class="form-control" placeholder="Please Enter GST Number" name="gst" value="{{ old('gst') }}">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('employee.customer.view')}}" class="btn btn-primary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop
