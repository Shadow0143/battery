@extends('admin.layout.app')
@section('title')
    Admin | Bar-code Search
@endsection
@section('body-content')

<?php $user = Auth::user(); 

 // echo '<pre>';print_r($products);die;?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Bar-code Search</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Bar-code Details</li>
        </ol>
      </div>
    </div>
  </div>
</section>
@include('admin.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
        <div class="card-tools">
        <!-- <a href="{{route('admin.product.add')}}" class="btn btn-primary">Add Product</a> -->
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped projects">
          <thead>
              <tr>
                  <td>Sl No</td>
                  <td>Product Name</td>
                  <td>Invoice Number</td>
                  <td>Client Name</td>
                  <td>Sale Date</td>
              </tr>
          </thead>
          <tbody>
            <?php if(!empty($products && $customers)){ ?>
            <tr>
                <td><?php echo $products->id; ?></td>
              <td><?php echo $products->name; ?></td>
              <td><?php echo $orders->invoice_number; ?></td>
              <td><?php echo $customers->name; ?></td>
              <td><?php echo date('d-m-Y', strtotime($scandetails->created_at)); ?></td>
            </tr>
          <?php }else{ ?>
          <tr>
              <td colspan="4">No Records Found</td>
            </tr>
          <?php } ?>
          </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
<?php /* {{ $items->links() }} */ ?>
</section>
<!-- /.content -->
@stop
