@extends('admin.layout.app')
@section('title')
    Admin | Item
@endsection
@section('body-content')

<?php $user = Auth::user(); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Item</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Item</li>
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

        <a href="{{route('admin.product.print')}}" class="btn btn-primary" target="_blank" onclick="return confirm('Do you want to Print Now?')" >PDF</a> 
        <a href="{{route('admin.product.csv')}}" class="btn btn-primary" onclick="return confirm('Do you want to Download Now?')" >CSV</a> 

        <!-- <a href="{{route('admin.product.add')}}" class="btn btn-primary">Add Product</a> -->
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
                  <th style="width: 16%"> Sl No. </th>
                  <th style="width: 16%"> Name </th>
                  <!-- <th style="width: 16%"> Category Name </th>
                  <th style="width: 16%"> Brand Name </th> -->
                  <th style="width: 16%"> Current Balance </th>
                  <th style="width: 16%"> Action </th>
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
                  <td> {{$count}} </td>
                  <td> {{$item->name}} </td>
                <?php /*  <td>
                    @if($item->category!== null)
                      {{$item->category->name}}
                    @endif
                  </td>
                  <td>
                    @if($item->brand !== null)
                    {{$item->brand->name}}
                    @endif
                  </td> */ ?>
                  
                  <td> {{$item->last_balance}} </td>

             <?php $stocksSearch = DB::table('stocks')->where('ref_product','=',$item->id)->pluck('id')->first();
              $order_detailsSearch = DB::table('order_details')->where('ref_product','=',$item->id)->pluck('id')->first();
             ?>

                  <td class="project-actions text-right">
                     
                      <a class="btn btn-info btn-sm" href="{{route('admin.product.edit',$item->id)}}">
                        <i class="fas fa-pencil-alt"></i>Edit 
                      </a>
                    @if(empty($stocksSearch) && empty($order_detailsSearch))
                      <?php  if($user->user_type==1){ ?> 
                      <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.product.delete',$item->id)}}">
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
                        No Product Exist on system, please add new
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
