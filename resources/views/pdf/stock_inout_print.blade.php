<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }
        a {
          color: #5D6975;
          text-decoration: underline;
        }
        body {
          position: relative;
          width: 100%;
          padding-bottom: 65px;
          margin: 0 auto;
          color: #001028;
          background: #FFFFFF;
          font-family: Arial, sans-serif;
          font-size: 12px;
          font-family: Arial;
        }
        header {
          padding: 10px 0;
          margin-bottom: 30px;
        }
        #logo {
          text-align: center;
          margin-bottom: 10px;
        }
        #logo img {
          width: 90px;
        }
        h1 {
          border-top: 1px solid  #5D6975;
          border-bottom: 1px solid  #5D6975;
          color: #5D6975;
          font-size: 2.4em;
          line-height: 1.4em;
          font-weight: normal;
          text-align: center;
          margin: 0 0 20px 0;
          background: url(dimension.png);
        }
        #project {
          float: left;
        }
        #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 10px;
          display: inline-block;
          font-size: 0.8em;
        }
        #company {
          float: right;
          text-align: right;
        }
        #project div,
        #company div {
          white-space: nowrap;
        }
        table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
        }
        table tr:nth-child(2n-1) td {
          /* background: #F5F5F5; */
        }
        table th,
        table td {
          text-align: center;
        }
        table th {
          padding: 5px 5px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: wrap;
          font-weight: normal;
        }
        table .service,
        table .desc {
          text-align: left;
        }
        table td {
          padding:5px 5px;
          text-align: right;
        }
        table td.service,
        table td.desc {
          vertical-align: top;
        }
        table td.unit,
        table td.qty,
        table td.total {
          font-size: 1.2em;
        }
        table td.grand {
          border-top: 1px solid #5D6975;;
        }
        #notices .notice {
          color: #5D6975;
          font-size: 1.2em;
        }
        footer {
          color: #5D6975;
          width: 100%;
          height: 30px;
          position: absolute;
          bottom: 0;
          border-top: 1px solid #C1CED9;
          padding: 8px 0;
          text-align: center;
        }
    </style>

  </head>
  <body>
    <header class="clearfix" style="text-align: center; width:700px; margin:auto;">
      <div id="project">
        <div> Stock  Inout List:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              Current DATE: {{date('d-m-Y')}}
        </div> 
      </div>
    </header>

    <main>
      <table border="2" style="width:700px; margin:auto;">
        <thead>
          <tr>
            <th width="2%" style="text-align: center; color:#000;">No.</th>
            <th width="10%" style="text-align: center; color:#000;">Date</th>
            <th width="10%" style="text-align: center; color:#000;">Invoice</th>
            <th width="10%" style="text-align: center; color:#000;">Product</th>
            <th width="10%" style="text-align: center; color:#000;">Customers / Dealer</th>
            <th width="8%" style="text-align: center; color:#000;">Opening Balance</th>
            <th width="8%" style="text-align: center; color:#000;">Quantity In</th>
            <th width="8%" style="text-align: center; color:#000;">Quantity Out</th>
            <th width="8%" style="text-align: center; color:#000;">Closing Balance</th>

          </tr>
        </thead>
       
        <tbody>
          <?php $inc=1; ?>

          <?php if(!empty($results)){
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
                  <td style="text-align: center;">{{$inc}}</td>
                  <td style="text-align: center;">{{$startdate126}}</td>
                  <td style="text-align: center;">{{$item['invoice_number']}}</td>
                  <td style="text-align: center;">{{$item['product_name']}}</td>
                  <td style="text-align: center;">{{$item['customers_name']}}</td>
                  <td style="text-align: center;"><?php if(!empty($openingbalance)) echo $openingbalance; ?></td>
                  <td style="text-align: center;"> @if($item['type']==1){{$item['quantity']}} @endif</td>
                  <td style="text-align: center;">@if($item['type']==2){{$item['quantity']}} @endif</td>
                  <td style="text-align: center;">@if(!empty($closingbalance->balance)) {{$closingbalance->balance}} @endif</td>
              </tr> 

            <?php $inc++; 
          } } ?>

        </tbody>
      </table>
     
    </main>
    <footer> all Details List was created on a computer and is valid without the signature and seal. </footer>
  </body>
</html>
