@extends('sales.layout.app')
@section('title')
    Sales | Customer
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('sales.sales-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Customer</li>
        </ol>
      </div>
    </div>
  </div>
</section>
@include('sales.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Customers</h3>

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
                      Phone Number
                  </th>
                  <th style="width: 20%">
                      Email Address
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
                      {{ $item->name }}
                  </td>
                  <td>
                      {{ $item->phone }}
                  </td>
                  <td>
                      {{ $item->email }}
                  </td>
              </tr>
            <?php endforeach;
            else:
            ?>
            <tr>
                <td colspan="8">
                    <div class="alert alert-danger" role="alert">
                        No Customer Exist on system
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
