@extends('admin.layout.app')
@section('title')
    Admin |All Stock In / Out
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
        <h1>Stock In / Out</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Stock In / Out</li>
        </ol>
      </div>
    </div>
  </div>
</section>
@include('admin.layout.alert')
<section class="content">
  <div class="card">
    <div class="card-header">
        <li>
        <form class="form-inline ml-6" action="{{route('admin.all-stock.search')}}" method="post">
            @csrf
            <div class="input-group input-group-sm">
              <input type="date" class="form-control form-control-navbar" name="start_date" value="{{ $start_date }}" placeholder="Start Date">
    <input type="date" class="form-control form-control-navbar" name="end_date" value="{{ $end_date }}" placeholder="Start Date">
    <input class="form-control form-control-navbar" type="text" name="search" placeholder="Search Text" aria-label="Search" value="{{ $search }}">
              <div class="input-group-append">
                <button class="btn btn-navbar subbtn" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </li>

      <div class="card-tools">
       <!--  <a href="{{route('admin.stock.add')}}" class="btn btn-primary">Add Stock New</a> -->
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
               <!--    <th style="width: 10%">
                      Sl No.
                  </th> -->

             <th style="width: 15%">
                    Date
                  </th>

                  <th style="width: 15%">
                  Invoice
                  </th>

                  <th style="width: 15%">
                  Product
                  </th>

                  <th style="width: 15%">
                   Customers / Dealer
                  </th>

                  

                  <th style="width: 10%">
                    Opening Balance
                  </th>

                  <th style="width: 10%">
                    Quantity In
                  </th>

                  <th style="width: 10%">
                    Quantity Out 
                  </th>

                  <th style="width: 10%">
                    Closing Balance
                  </th>

              </tr>
          </thead>
          <tbody>
            <?php if(!empty($results)){
               $count=1;
                foreach($results as $item){ // echo '<pre>'; print_r($results);die;

                 $startdate126 = date('d-m-Y', strtotime($item['created_at']));

                 $startdate124 = date('Y-m-d', strtotime($item['created_at']));
                $startdate123 = $startdate124.' 00-00-00';

                $startdate = date('Y-m-d', strtotime($item['created_at']. ' -1 day'));
                $startdate = $startdate.' 00-00-00';
                $enddate = date('Y-m-d', strtotime($item['created_at']. ' -1 day'));
                $enddate = $enddate.' 23-59-59';
                 $today = date('Y-m-d H:i:s');
                // DB::enableQueryLog();
                 $openingbalance = DB::table('order_stock_map')
                   ->where('product_id',$item['product_id'])
                   ->where('created_at','<',$startdate123)
                   ->orderBy('created_at', 'desc')->first(); 
                   if(empty($openingbalance)){
                    $openingbalance = DB::table('order_stock_map')
                   ->where('product_id',$item['product_id'])
                   //->where('created_at','<',$startdate123)
                   ->orderBy('created_at', 'asc')->first(); 
                   }
              // dd(DB::getQueryLog());
                  if($item['type']==2) {
                   


                //    if(empty($openingbalance)){
                //    // $openingbalance=121;
                //     $startdate = date('Y-m-d', strtotime($item['created_at']));
                // $startdate = $startdate.' 00-00-00';
                // $enddate = date('Y-m-d', strtotime($item['created_at']));
                // $enddate = $enddate.' 23-59-59';
                //     $openingbalance = DB::table('order_stock_map')
                //     ->where('product_id',$item['product_id'])
                //     ->where('balance','!=',NULL)
                //    ->whereBetween('created_at', [$startdate,$enddate])
                //    ->orderBy('id', 'desc')->first();
                //    }
                   
                   $closingbalance = DB::table('order_stock_map')->where('order_details_id',$item['id'])
                   ->orderBy('id', 'desc')->first();
                  } 
 
                  if($item['type']==1) {
                  // $openingbalance = DB::table('order_stock_map')->where('product_id',$item['product_id'])
                   //->where('created_at','<',$item['created_at'])
                   //->orderBy('id', 'desc')->first();


                //    if(empty($openingbalance)){
                //   //  $openingbalance=212;
                //   //  DB::enableQueryLog(); 
                //     $startdate = date('Y-m-d', strtotime($item['created_at']));
                // $startdate = $startdate.' 00-00-00';
                // $enddate = date('Y-m-d', strtotime($item['created_at']));
                // $enddate = $enddate.' 23-59-59';
                //     $openingbalance = DB::table('order_stock_map')
                //     ->where('product_id',$item['product_id'])
                //     ->where('balance','!=',NULL)
                //    ->whereBetween('created_at', [$startdate,$enddate])
                //    ->orderBy('id', 'desc')->first();
                //   // dd(DB::getQueryLog());
                //    }
                   
                   $closingbalance = DB::table('order_stock_map')->where('stocks_id',$item['id'])
                   ->orderBy('id', 'desc')->first();
                
              } ?>
              <tr> 
                   <!-- <td><?php // echo $count; ?></td> -->
                   
                  <td><?php echo $startdate126; ?></td>
                  <td><?php echo $item['invoice_number']; ?></td>
                  <td><?php echo $item['product_name']; ?></td>
                  <td><?php echo $item['customers_name']; ?></td>

                  <td><?php if(!empty($openingbalance->balance)) echo $openingbalance->balance; ?></td>
                   
                  <td><?php if($item['type']==1) {echo $item['quantity'];} ?></td>
                  <td><?php if($item['type']==2) {echo $item['quantity'];} ?></td>

                  <td><?php if(!empty($closingbalance->balance)) echo $closingbalance->balance; ?></td>
              </tr> 

            <?php $count++; } }else{ ?>
            <tr>
                <td colspan="8">
                     <div class="alert alert-danger" role="alert">
                        No Recods Found
                    </div>
                </td>
            </tr>
          <?php } ?>
          </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->
@stop
