@extends('employee.layout.app')
@section('title')
    Employee |Stock Details
@endsection
@section('body-content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Stock Selling Details</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('employee.employee-dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employee.all-stock.view')}}">Stock</a></li>
            <li class="breadcrumb-item active">Stock Selling Details</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  @include('employee.layout.alert')
  <section class="content">
    <div class="card">
      <div class="card-header date_sec02">
          <div class="right_box01">
              <div class="field_box">
                <input type="text" class="InputNameSearch" placeholder="Invoice Number">
              </div>
              <br>
              <div class="field_box">
              <input type="hidden" value="{{$AjaxId}}" class="ajxId">
                <input type="date" placeholder="Date From" class="InputSearchDateStart">
                <span>To</span>
                <input type="date" placeholder="Date End" class="InputSearchDateEnd">
              </div>
          </div>
        <div class="card-tools">
          <a href="{{route('employee.all-stock.view')}}" class="btn btn-primary">Back</a>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                  <th style="width: 20%">
                      Date
                  </th>
                  <th style="width: 20%">
                    Invoice Number
                    </th>
                    <th style="width: 20%">
                      Dealer / Customer
                    </th>
                    <th style="width: 20%">
                      Quantity
                    </th>
                </tr>
            </thead>
            <tbody class="SearchResult">
              <?php
              if($items->isNotEmpty()):
                  $count = 0;
                  foreach($items as $item):
                      $count++;
                      ?>
                <tr>
                  <?php
                  $order=App\Models\Order::find($item->ref_order);
                  $product=$item->ref_product;
                  $quantity=App\Models\Product::find($product)->opening_balence;
                  $stocks=App\Models\Stock::where('ref_product',$product)->get();
                  foreach ($stocks as $stock) {
                      $quantity=$quantity+intval($stock->quantity);
                  }
                  ?>
                  <td>
                      {{ Carbon\Carbon::createFromFormat('Y-m-d', $order->date)->format('d.m.Y') }}
                    </td>
                    <td>
                        {{$order->invoice_number}}
                    </td>
                    <td>
                      {{App\Models\Customer::find($order->ref_customer)->name}}
                    </td>
                    <td>
                        {{$item->quantity}}
                    </td>
                </tr>

              <?php endforeach;
              else:
              ?>
              <tr>
                  <td colspan="8">
                      <div class="alert alert-danger" role="alert">
                          No Details Found...
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
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script>
      $(function () {
          $('.InputNameSearch').keyup(function() {
              console.log( $('.InputNameSearch').val() );
              var searchValue = $('.InputNameSearch').val();
              var Id =$('.ajxId').val();
              $.ajax({
                  type: 'get',
                  dataType: 'html',
                  url: '/filter-live-search',
                  data: {SearchInvoice : searchValue,id : Id},
                  success: function (response) {
                      $('.SearchResult').html(response);
                  }
              })
           });
           $('.InputSearchDateStart').change(function() {
              // console.log( $('.InputSearchDateStart').val() );
              var statrtDate = $('.InputSearchDateStart').val();
              var endDate = $('.InputSearchDateEnd').val();
              var searchValue = $('.InputNameSearch').val();
              var Id =$('.ajxId').val();
              $.ajax({
                  type: 'get',
                  dataType: 'html',
                  url: '/filter-live-search-date-beeten',
                  data: {StartDate : statrtDate,EndDate : endDate,SearchInvoice : searchValue,id : Id},
                  success: function (response) {
                      $('.SearchResult').html(response);
                  }
              })
           });
           $('.InputSearchDateEnd').change(function() {
              // console.log( $('.InputSearchDateStart').val() );
              var statrtDate = $('.InputSearchDateStart').val();
              var endDate = $('.InputSearchDateEnd').val();
              var searchValue = $('.InputNameSearch').val();
              var Id =$('.ajxId').val();
              $.ajax({
                  type: 'get',
                  dataType: 'html',
                  url: '/filter-live-search-date-beeten',
                  data: {StartDate : statrtDate,EndDate : endDate,SearchInvoice : searchValue,id : Id},
                  success: function (response) {
                      $('.SearchResult').html(response);
                  }
              })
           });

      })
  </script>
  @stop
