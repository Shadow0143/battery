@extends('admin.layout.app')
@section('title')
    Admin | Customer
@endsection
@section('body-content')

<?php $user = Auth::user(); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Customer</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@include('admin.layout.alert')
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
        <div class="card-tools">
       <!--  <a href="{{route('admin.customer.add')}}" class="btn btn-primary">Add Customer</a> -->
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
                  <!-- <th style="width: 20%">Sl No.</th> -->
                  <th style="width: 20%">Customer Name</th>
                  <th style="width: 20%">Type</th>
                  <th style="width: 20%">Phone Number</th>
                  <th style="width: 20%">Email Address</th>
                  <th style="width: 20%">Action</th>
              </tr>
          </thead>
          <tbody>
            <?php
            if($items->isNotEmpty()):
                $count = 0;
                foreach($items as $item):
                    $count++;
                    ?>
              <tr>
                  <!-- <td>{{$count}}</td> -->
                  <td>{{ $item->name }}</td>
                  <td><?php if($item->type==1) echo 'Dealer'; else echo 'Customer';?></td>
                  <td>{{ $item->phone }}</td>
                  <td>{{ $item->email }}</td>
                  
                  <td class="project-actions text-right">
                   
                <?php 
                  $stocksSearch = DB::table('stock_details')->where('ref_customer','=',$item->id)->pluck('id')->first(); 
                  $ordersSearch = DB::table('orders')->where('ref_customer','=',$item->id)->pluck('id')->first(); 
                ?>
                      <a class="btn btn-info btn-sm" href="{{route('admin.customer.edit',$item->id)}}">
                        <i class="fas fa-pencil-alt"></i>Edit
                      </a>
                      
                    @if(empty($stocksSearch) && empty($ordersSearch))
                      <?php  if($user->user_type==1){ ?>
                      <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.customer.delete',$item->id)}}">
                        <i class="fas fa-trash"></i>Delete
                      </a>
                      <?php } ?>
                    @endif

                  </td>
              </tr>
            <?php endforeach;
            else:
            ?>
            <tr>
                <td colspan="8">
                    <div class="alert alert-danger" role="alert">
                        No Customer Exist on system, please add new
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
