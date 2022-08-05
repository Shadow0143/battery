<?PHP  
use App\Models\ScanCode;
 ?>
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
    width: 21cm;
    height: 29.7cm;
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
    padding: 5px 20px;
    color: #5D6975;
    border-bottom: 1px solid #C1CED9;
    white-space: nowrap;
    font-weight: normal;
  }

  table .service,
  table .desc {
    text-align: left;
  }

  table td {
    padding: 20px;
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
    <header class="clearfix">

      <!-- <h1>INVOICE</h1> -->
      <!-- <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div> -->
      <div id="project">
        <div>Name: {{$client->name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATE: {{date('d-m-Y', strtotime($item->date))}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Invoice Number: {{$item->invoice_number}}</div>
        <?php /* <div><span>ADDRESS</span> {{$item->address}}</div>
        <div><span>PHONE</span>{{$item->phone_num ber}}</div>
         */ ?>
      </div>
    </header>
    <main>
      <table border="2" style="width:89%">
        <thead>
          <tr>
            <th width="20%" style="text-align: center; color:#000;">Product Name</th>
            <th width="10%" style="text-align: center; color:#000;">Item Quantity</th>
            <th width="50%" style="text-align: center; color:#000;">Serial Numbers</th>
          </tr>
        </thead>
        <tbody>
        
          @foreach($pdf_order_details as $pdf_order_detail)
     <tr>
       
        <td style="text-align: center;">{{App\Models\Product::find($pdf_order_detail->ref_product)->name}}</td>
            <!-- <td style="text-align: center;">{{$pdf_order_detail->quantity}}</td> -->
           
            <?php $itemCount = DB::table('sacn_codes')->where('ref_order',$item->id)->where('ref_order_details',$pdf_order_detail->id)->count(); ?>
            <td style="text-align: center;">{{$itemCount}}</td>

            <td style="text-align: center;">
              @php($bar_codes=App\Models\ScanCode::where('ref_order',$item->id))
              <?php $scancode_list=ScanCode::where('ref_order_details',$pdf_order_detail->id)->get(); ?>
              @foreach($scancode_list as $bar_code)
              {{$bar_code->scan_code}},           
              @endforeach
            </td>
          </tr>
       
          @endforeach
        </tbody>
      </table>
      <!-- <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> -->
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
