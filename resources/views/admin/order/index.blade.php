@extends('admin.layout.app')
@section('title')
    Admin | Order
@endsection
@section('body-content')
<style>
.card-header li
{
  display: inline-block;
}
.card-header li form
{
  float: right;
  margin-left: 617px !important;
  margin-top: 6px;
}
.subbtn
{
  border: 1px solid #ced4da;
}
</style>

<?php $user = Auth::user(); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Order</li>

        </ol>
      </div>
    </div>
  </div>
</section>
@include('admin.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
      <!-- <li>  <form class="form-inline ml-6" action="{{route('admin.order.search')}}" method="post">
          @csrf
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="text" name="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar subbtn" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form></li> -->

      <div class="card-tools">

        <!-- <a href="{{route('admin.order.add')}}" class="btn btn-primary">Add Order</a> -->
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped projects" id="pagi">
          <thead>
              <tr>
                  <th style="width: 20%">Sl No.</th>
                  <th style="width: 20%">Customer Name</th>
                  <th style="width: 20%">Invoice Number</th>
                  <th style="width: 20%">Date</th>
                  <th style="width: 20%">Product With Quantity</th>
                  <th style="width: 20%">Action</th>
              </tr>
          </thead>
          <tbody>
            <?php
                // dd($items);
            if($items->isNotEmpty()):
                $count = 0;
                foreach($items as $item):
                    $count++;
                    ?>
              <tr>
                  <td>{{$count}}</td>
                  <td> @if($item->customer!== null){{$item->customer->name}}@endif </td>
                  <td> {{$item->invoice_number}} </td>
                  <td>{{date('d-m-Y', strtotime($item->date))}}</td>
                  <!-- <td> {{Carbon\Carbon::createFromFormat('Y-m-d',$item->date)->format('d.m.Y')}} </td> -->

                  <td>
                  @php($order_details=App\Models\OrderDetail::select('ref_product','quantity')->where('ref_order',$item->id)->get())
                    @foreach($order_details as $order_row)
                      @php($product=App\Models\Product::where('id',$order_row->ref_product)->pluck('name')->first())
                      <p>Product: {{$product}} Quantity: {{$order_row->quantity}}</P>
                    @endforeach

                  <?php // change code 19-04-2021 
                   /*  @php($order_details=App\Models\OrderDetail::where('ref_order',$item->id)->get())
                    @foreach($order_details as $order_detail)
                      @php($products=App\Models\Product::find($order_detail))
                      @foreach($products as $product)
                      <p>{{$product->name}}</P>
                      @endforeach
                    @endforeach  */?>

                  </td>
                  <td class="project-actions text-right">
                    <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$item->id)}}">View</a>
                    <a class="btn btn-info btn-sm" target="_blank" href="{{route('admin.order.reprint',$item->id)}}">Print</a>
                      <?php  if($user->user_type==1){ ?>
                      <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.order.delete',$item->id)}}"><i class="fas fa-trash"></i>Delete</a>
                      <?php } ?>
                  </td>
              </tr>
            <?php endforeach;
            else:
            ?>
            <tr>
                <td colspan="8">
                    <div class="alert alert-danger" role="alert">
                        No Order Exist on system, please add new
                    </div>
                </td>
            </tr>
            <?php
            endif; ?>
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
