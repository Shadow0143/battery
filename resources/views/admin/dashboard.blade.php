@extends('admin.layout.app')
@section('title')
    Admin | Dashboard
@endsection
@section('body-content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$product_count}}</h3>
            <p>Product</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{route('admin.product.view')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$customer_count}}</h3>
            <p>Customers</p>
          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <a href="{{route('admin.customer.view')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <p>Enter Bar-code Details</p>
          </div>

         <!--  <a href="{{route('admin.product.serachbarcode')}}" class="btn btn-primary">Search Bar-Code</a> -->
          <form  role="form" action="{{route('admin.product.serachbarcode')}}" method="get" enctype="multipart/form-data" class="small-box-footer">
          <input type="text" name="barcode" value="">
          <input type="submit" name="submit" value="Search">
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@stop
