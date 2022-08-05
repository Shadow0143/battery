<table class="table table-striped projects table-responsive" id="pagi">
  <thead>
    <tr>
     <!--    <th style="width: 10%">Sl No.</th> -->
        <th style="display:none; width: 15%">Datetime</th>
        <th style="width: 15%">Date</th>
        <th style="width: 15%">Invoice</th>
        <th style="width: 15%">Product</th>
        <th style="width: 15%">Customers / Dealer</th>
        <th style="width: 10%">Opening Balance</th>
        <th style="width: 10%">Quantity In</th>
        <th style="width: 10%">Quantity Out</th> 
        <th style="width: 10%">Closing Balance</th>
        <th style="width: 10%">Action</th>
    </tr>
</thead>

<tbody id="will_remove">
  <?php if(!empty($results)){
     $count=1;
      foreach($results as $item){ 

      $startdate126 = date('d-m-Y', strtotime($item['created_at']));
      $startdate124 = date('Y-m-d', strtotime($item['created_at']));
      $startdate123 = $startdate124.' 00-00-00';
      $startdate = date('Y-m-d', strtotime($item['created_at']. ' -1 day'));
      $startdate = $startdate.' 00-00-00';
      $enddate = date('Y-m-d', strtotime($item['created_at']. ' -1 day'));
      $enddate = $enddate.' 23-59-59';
       $today = date('Y-m-d H:i:s');
      

        if($item['type']==2) {
         $orderdtls = DB::table('order_details')->where('id',$item['id'])->orderBy('id', 'desc')->first();
         $closingbalance = DB::table('order_stock_map')->where('order_details_id',$item['id'])->orderBy('id', 'desc')->first();
         
         $openingbalance = ($closingbalance->balance)+$item['quantity'];
        } 

        if($item['type']==1) {
         $closingbalance = DB::table('order_stock_map')->where('stocks_id',$item['id'])->orderBy('id', 'desc')->first();

         $openingbalance = ($closingbalance->balance)-$item['quantity'];
        } 
        
        ?>

    <tr>  
        <td style="display:none;"><?php echo strtotime($startdate126); ?></td>
        <td><?php echo $startdate126; ?></td>
        <td><?php echo $item['invoice_number']; ?></td>
        <td><?php echo $item['product_name']; ?></td>
        <td><?php echo $item['customers_name']; ?></td>
        <td><?php if(!empty($openingbalance)) echo $openingbalance; ?></td>
        <td><?php if($item['type']==1) {echo $item['quantity'];} ?></td>
        <td><?php if($item['type']==2) {echo $item['quantity'];} ?></td>
        <td><?php if(!empty($closingbalance->balance)) echo $closingbalance->balance; ?></td>
        <td>
          <?php  if($item['type']==2){ ?>                 
            <a class="btn btn-info btn-sm" target="_blank" href="{{route('admin.order.reprint',$orderdtls->ref_order)}}">Print</a>
          <?php } ?>
        </td>
    </tr> 

  <?php $count++; } }else{ ?>
    <tr>
      <td colspan="8">
          <div class="text-center text-danger" > No data found.  </div>
      </td>
    </tr>

<?php } ?>


</tbody>

</table>


