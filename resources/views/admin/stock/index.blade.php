@extends('admin.layout.app')
@section('title')
    Admin | Purchase
@endsection
@section('body-content')

<?php $user = Auth::user(); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Purchase New</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Purchase New</li>
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
        <!-- <a href="{{route('admin.stock.add')}}" class="btn btn-primary">Add Stock New</a> -->
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
                  <th style="width: 10%">Sl No.</th>
                  <th style="width: 20%">Dealer Name</th>
                  <th style="width: 15%">Invoice Number</th>
                  <th style="width: 15%">Date</th>
                  <th style="width: 20%">Product With Quantity</th>
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
                  <td>{{$count}}</td>
                  <td>
                    @if($item->customer!== null)
                      {{$item->customer->name}}
                    @endif
                  </td>
                  <td>{{$item->invoice}}</td>
                  <td>{{date('d-m-Y', strtotime($item->date))}}</td>
                  <td>
                    @php($stocks=App\Models\Stock::where('ref_stock_detail',$item->id)->get())
                    @foreach($stocks as $stock)
                    <p>Product: {{App\Models\Product::Find($stock->ref_product)->name}} Quantity: {{$stock->quantity}}</p>
                    @endforeach
                  </td>
                  <td class="project-actions text-right">
                    
                      <a class="btn btn-info btn-sm" href="{{route('admin.stock.edit',$item->id)}}">
                        <!-- <i class="fas fa-pencil-alt"></i> -->View
                      </a>
                      <?php  if($user->user_type==1){ ?>
                   
                      <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.stock.delete',$item->id)}}"><i class="fas fa-trash"></i>Delete</a>
                      <?php } ?>
                  </td>
              </tr>
            <?php endforeach;
            else:
            ?>
            <tr>
                <td colspan="8">
                    <div class="alert alert-danger" role="alert">
                        No Stock Exist on system, please add new
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
