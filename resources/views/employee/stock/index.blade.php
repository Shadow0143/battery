@extends('employee.layout.app')
@section('title')
    Employee | Stock
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Stock New</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('employee.employee-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Stock New</li>
        </ol>
      </div>
    </div>
  </div>
</section>
@include('employee.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
      <div class="card-tools">
        <a href="{{route('employee.stock.add')}}" class="btn btn-primary">Add Stock New</a>
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
                  <th style="width: 25%">
                      Sl No.
                  </th>
                  <th style="width: 25%">
                  Invoice Number
                  </th>
                  <th style="width: 25%">
                  Date
                  </th>
                  <th style="width: 25%">
                  Product With Quantity
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
                      {{$item->invoice}}
                  </td>
                  <td>
                      {{$item->date}}
                  </td>
                  <td>
                  @php($stocks=App\Models\Stock::where('ref_stock_detail',$item->id)->get())
                  @foreach($stocks as $stock)
                  <p>Product: {{App\Models\Product::Find($stock->ref_product)->name}} Quantity: {{$stock->quantity}}</p>
                  @endforeach
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
