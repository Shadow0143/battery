@extends('sales.layout.app')
@section('title')
    Employee |All Stock
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Stock</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('sales.sales-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Stock</li>
        </ol>
      </div>
    </div>
  </div>
</section>
@include('sales.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
        <li>
            <form class="form-inline ml-6" action="{{route('sales.all-stock.search')}}" method="post">
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
                Product Name
                </th>
                <th style="width: 20%">
                Total Stock Quantity
                </th>
                <th style="width: 20%">
                  Total Stock After Sell
                </th>
                <th style="width: 20%">
                  Details
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
                      {{$item->name}}
                  </td>
                  <td>
                      <?php
                      $stocks=App\Models\Stock::where('ref_product',$item->id)->get();
                       $quantity=$item->opening_balence;
                       ?>
                       @foreach($stocks as $stock)
                       <?php
                       $quantity=$quantity+intval($stock->quantity);
                       ?>
                       @endforeach
                       {{$quantity}}
                  </td>
                  <td>
                      <?php
                      $orders=App\Models\OrderDetail::where('ref_product',$item->id)->get();
                        ?>
                    @foreach($orders as $order)
                        <?php
                        $quantity=$quantity-intval($order->quantity);
                        ?>
                    @endforeach
                    {{ $quantity }}
                  </td>
                  <td>
                    <a class="btn btn-info btn-sm" href="{{route('sales.all-stock.details',$item->id)}}">
                        <i class="fas fa-eye-alt">
                        </i>
                        Details
                    </a>
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
{{ $items->links() }}
</section>
<!-- /.content -->
@stop
