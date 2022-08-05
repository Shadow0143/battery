@extends('sales.layout.app')
@section('title')
    Sales | Order
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
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('sales.sales-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Order</li>

        </ol>
      </div>
    </div>
  </div>
</section>
@include('sales.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
      <li class="card-title">Order</li>
      <li>
          <form class="form-inline ml-6" action="{{route('sales.order.search')}}" method="post">
          @csrf
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="text" name="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar subbtn" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </li>

      <div class="card-tools">
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
                  <th style="width: 20%">
                      Sl No.
                  </th>
                  <th style="width: 20%">
                  Customer Name
                  </th>
                  <th style="width: 20%">
                  Invoice Number
                  </th>
                  <th style="width: 20%">
                  Date
                  </th>
                  <th style="width: 20%">
                  Product
                  </th>
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
                  <td>
                      {{$count}}
                  </td>
                  <td>
                    @if($item->customer!== null)
                      {{$item->customer->name}}
                    @endif
                  </td>
                  <td>
                    {{$item->invoice_number}}
                  </td>
                  <td>
                    {{$item->date}}
                  </td>
                  <td>
                    @php($order_details=App\Models\OrderDetail::where('ref_order',$item->id)->get())
                    @foreach($order_details as $order_detail)
                      @php($products=App\Models\Product::find($order_detail))
                      @foreach($products as $product)
                      <p>{{$product->name}}</P>
                      @endforeach
                    @endforeach
                  </td>
              </tr>
            <?php endforeach;
            else:
            ?>
            <tr>
                <td colspan="8">
                    <div class="alert alert-danger" role="alert">
                        No Order Exist on system
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
{{ $items->links() }}
</section>
<!-- /.content -->
@stop
