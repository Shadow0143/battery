<?php
namespace App\Http\Controllers\Admin;

use App\Models\StockDetail;
use App\Models\Product;
use App\Models\Stock;
use App\Models\OrderDetail;
use App\Models\ScanCode;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ExtraController;
use PDF;

class StockController extends Controller{
    public function index(){
      $user = Auth::user();
      $products=Product::get();
        // $items=StockDetail::orderBy('created_at', 'desc')->paginate(10);
        $items=StockDetail::orderBy('created_at', 'desc')->get();
        return view('admin.stock.index',compact('items','user','products'));
    }

    public function searchBYDate(Request $request)
    {
        if($request->start_date =='')
        {
            $start_date = date("Y-m-d",strtotime("-1 month"));
        }else{

            $start_date = date('Y-m-d',strtotime($request->start_date));
        }

        if($request->end_date == ''){
            $end_date = date('Y-m-d');
        }
        else{
            $end_date =  date('Y-m-d',strtotime($request->end_date));
        }

        $listDataOrder = DB::table('order_details')
        ->leftJoin('orders', 'order_details.ref_order', '=', 'orders.id')
        ->join('customers', 'orders.ref_customer', '=', 'customers.id')
        ->join('products', 'order_details.ref_product', '=', 'products.id')
        ->select('order_details.id as order_details_id','order_details.ref_order as order_id','products.id as product_id','products.name as product_name','order_details.created_at as created_at','order_details.quantity as quantity_out','orders.date as date','orders.invoice_number as invoice_number','customers.name as customers_name')
        ->whereBetween('order_details.created_at',[$start_date,$end_date])
        ->orderBy('order_details.created_at','desc') 
        ->get();


        $listDataStock = DB::table('stocks')
        ->leftJoin('stock_details', 'stocks.ref_stock_detail', '=', 'stock_details.id')
        ->join('customers', 'stock_details.ref_customer', '=', 'customers.id')
        ->join('products', 'stocks.ref_product', '=', 'products.id')
        ->select('stocks.id as stocks_id','products.id as product_id','products.name as product_name','stocks.created_at as created_at','stocks.quantity as quantity_in','stock_details.date as date','stock_details.invoice as invoice_number','customers.name as customers_name')
        ->whereBetween('stocks.created_at',[$start_date,$end_date])
        ->orderBy('stocks.created_at','desc') 
         ->get();

            $results=[];
            $iii=0;
            if(!empty($listDataOrder)){
            foreach($listDataOrder as $row){
                $results[$iii]['id']=             $row->order_details_id; 
                $results[$iii]['product_id']=   $row->product_id;
                $results[$iii]['product_name']=   $row->product_name;
                $results[$iii]['quantity']=       $row->quantity_out;
                $results[$iii]['invoice_number']= $row->invoice_number;
                $results[$iii]['customers_name']= $row->customers_name;
                $results[$iii]['date']=           $row->date;
                $results[$iii]['created_at']=     $row->created_at;
                $results[$iii]['type']= 2;

                $iii++;
            }
            }

            if(!empty($listDataStock)){
            foreach($listDataStock as $row){

                $results[$iii]['id']=             $row->stocks_id; 
                $results[$iii]['product_id']=   $row->product_id;
                $results[$iii]['product_name']=   $row->product_name;
                $results[$iii]['quantity']=       $row->quantity_in;
                $results[$iii]['invoice_number']= $row->invoice_number;
                $results[$iii]['customers_name']= $row->customers_name;
                $results[$iii]['date']=           $row->date;
                $results[$iii]['created_at']=     $row->created_at;
                $results[$iii]['type']= 1;

                $iii++; 
            }
            }

            if(!empty($results)){ 
                foreach ($results as $key => $part) {
                    $sort[$key] = strtotime($part['created_at']);
                }
                array_multisort($sort, SORT_ASC, $results);
            }

        $user = Auth::user();
        return view('admin.all-stock.ajax_seach_b_date',compact('results','user'));

    }

    public function AllStockView()
    {    

            $results=[];
            $user = Auth::user();
            $search='';
            $start_date = '';
            $end_date = '';
        return view('admin.all-stock.inout',compact('results','user','search','start_date','end_date'));
    }

    public function AllStockView_bkp_22_07_2022()
    {    

            $listDataOrder = DB::table('order_details')
            ->leftJoin('orders', 'order_details.ref_order', '=', 'orders.id')
            ->join('customers', 'orders.ref_customer', '=', 'customers.id')
            ->join('products', 'order_details.ref_product', '=', 'products.id')
            ->select('order_details.id as order_details_id','order_details.ref_order as order_id','products.id as product_id','products.name as product_name','order_details.created_at as created_at','order_details.quantity as quantity_out','orders.date as date','orders.invoice_number as invoice_number','customers.name as customers_name')
            ->orderBy('order_details.created_at','desc') 
            ->paginate(10);

            $listDataStock = DB::table('stocks')
            ->leftJoin('stock_details', 'stocks.ref_stock_detail', '=', 'stock_details.id')
            ->join('customers', 'stock_details.ref_customer', '=', 'customers.id')
            ->join('products', 'stocks.ref_product', '=', 'products.id')
            ->select('stocks.id as stocks_id','products.id as product_id','products.name as product_name','stocks.created_at as created_at','stocks.quantity as quantity_in','stock_details.date as date','stock_details.invoice as invoice_number','customers.name as customers_name')
            ->orderBy('stocks.created_at','desc') 
                ->paginate(10);

                $results=[];
                $iii=0;
                if(!empty($listDataOrder)){
                foreach($listDataOrder as $row){
                    $results[$iii]['id']=             $row->order_details_id; 
                    $results[$iii]['product_id']=   $row->product_id;
                    $results[$iii]['product_name']=   $row->product_name;
                    $results[$iii]['quantity']=       $row->quantity_out;
                    $results[$iii]['invoice_number']= $row->invoice_number;
                    $results[$iii]['customers_name']= $row->customers_name;
                    $results[$iii]['date']=           $row->date;
                    $results[$iii]['created_at']=     $row->created_at;
                    $results[$iii]['type']= 2;

                    $iii++;
                }
                }

                if(!empty($listDataStock)){
                foreach($listDataStock as $row){

                    $results[$iii]['id']=             $row->stocks_id; 
                    $results[$iii]['product_id']=   $row->product_id;
                    $results[$iii]['product_name']=   $row->product_name;
                    $results[$iii]['quantity']=       $row->quantity_in;
                    $results[$iii]['invoice_number']= $row->invoice_number;
                    $results[$iii]['customers_name']= $row->customers_name;
                    $results[$iii]['date']=           $row->date;
                    $results[$iii]['created_at']=     $row->created_at;
                    $results[$iii]['type']= 1;

                    $iii++; 
                }
                }

                if(!empty($results)){ 
                    foreach ($results as $key => $part) {
                        $sort[$key] = strtotime($part['created_at']);
                    }
                    array_multisort($sort, SORT_ASC, $results);
                }

            $user = Auth::user();
            $search='';
            $start_date = '';
            $end_date = '';
        return view('admin.all-stock.inout',compact('results','user','search','start_date','end_date'));
    }

     public function AllStock()
    {
     
      $user = Auth::user();
     // $items=Product::paginate(10);
      $items=Product::all();
      return view('admin.all-stock.index',compact('items','user'));
    }

    public function searchAllStock(Request $request)
    {

         $user = Auth::user();
      $search=$request->search;
      $start_date = $request->start_date;
       $end_date = $request->end_date;
        //$search= $request->input('search');

     //echo $start_date;die;
        if($start_date==''){$start_date='2020-08-10';}
          if($end_date==''){$end_date=date("Y-m-d");}
         $where_clause = "order_details.created_at BETWEEN '".$start_date."' AND '".$end_date."' AND (products.name LIKE '%".$search."%' OR orders.invoice_number LIKE '%".$search."%')";
         $where_clause2 = "stocks.created_at BETWEEN '".$start_date."' AND '".$end_date."' AND (products.name LIKE '%".$search."%' OR stock_details.invoice LIKE '%".$search."%')";
         DB::enableQueryLog();

        $listDataOrder = DB::table('order_details')
            ->leftJoin('orders', 'order_details.ref_order', '=', 'orders.id')
            ->join('customers', 'orders.ref_customer', '=', 'customers.id')
            ->join('products', 'order_details.ref_product', '=', 'products.id')
            ->select('order_details.id as order_details_id','order_details.ref_order as order_id','products.id as product_id','products.name as product_name','order_details.created_at as created_at','order_details.quantity as quantity_out','orders.date as date','orders.invoice_number as invoice_number','customers.name as customers_name')      
            //->whereBetween('orders.date', [$start_date,$end_date])
            ->whereRaw($where_clause)
           // ->where('products.name', 'LIKE', "%{$request->input('search')}%")
            //->orwhere('orders.invoice_number', 'LIKE', "%{$request->input('search')}%")
            ->orderBy('order_details.created_at','desc')
            ->get();
        // dd(DB::getQueryLog()); 
            $listDataStock = DB::table('stocks')
            ->leftJoin('stock_details', 'stocks.ref_stock_detail', '=', 'stock_details.id')
            ->join('customers', 'stock_details.ref_customer', '=', 'customers.id')
            ->join('products', 'stocks.ref_product', '=', 'products.id')
            ->select('stocks.id as stocks_id','products.id as product_id','products.name as product_name','stocks.created_at as created_at','stocks.quantity as quantity_in','stock_details.date as date','stock_details.invoice as invoice_number','customers.name as customers_name')
            //->whereBetween('stock_details.date', [$start_date,$end_date])
            ->whereRaw($where_clause2)
           // ->where('products.name', 'LIKE', "%{$request->input('search')}%")
            //->orwhere('stock_details.invoice', 'LIKE', "%{$request->input('search')}%")
            ->orderBy('stocks.created_at','desc') 
                ->get(); 

                 $iii=0;
                foreach($listDataOrder as $row){

                    $results[$iii]['id']=             $row->order_details_id; 
                    $results[$iii]['product_id']=   $row->product_id;
                    $results[$iii]['product_name']=   $row->product_name;
                    $results[$iii]['quantity']=       $row->quantity_out;
                    $results[$iii]['invoice_number']= $row->invoice_number;
                    $results[$iii]['customers_name']= $row->customers_name;
                    $results[$iii]['date']=           $row->date;
                    $results[$iii]['created_at']=     $row->created_at;
                    $results[$iii]['type']= 2;

                $iii++; }

                foreach($listDataStock as $row){

                    $results[$iii]['id']=             $row->stocks_id; 
                    $results[$iii]['product_id']=   $row->product_id;
                    $results[$iii]['product_name']=   $row->product_name;
                    $results[$iii]['quantity']=       $row->quantity_in;
                    $results[$iii]['invoice_number']= $row->invoice_number;
                    $results[$iii]['customers_name']= $row->customers_name;
                    $results[$iii]['date']=           $row->date;
                    $results[$iii]['created_at']=     $row->created_at;
                    $results[$iii]['type']= 1;

                $iii++; }

         
                if(!empty($results)) {
                foreach ($results as $key => $part) {
                   $sort[$key] = strtotime($part['created_at']);
                    }
                array_multisort($sort, SORT_ASC, $results);
            }else{
              $results=array();  
            }
        
        if(!empty($request->start_date)){$start_date = $request->start_date;}else{$start_date ='';}
        if(!empty($request->end_date)){$end_date = $request->end_date;}else{$end_date ='';} 
       
       
      //$items=Product::where('name', 'LIKE', "%{$request->input('search')}%")->paginate(10);
        return view('admin.all-stock.search',compact('results','user','search','start_date','end_date'));
    }
    
    public function AllStockDetails($id){
     $AjaxId=$id;
     $user = Auth::user();
        // $items=OrderDetail::where('ref_product',$id)->paginate(10);
     $items=OrderDetail::where('ref_product',$id)->get();
     return view('admin.all-stock.details',compact('items','user','AjaxId'));
    }

    public function add(){
      $customers=Customer::get();
      $user = Auth::user();
      $products=Product::get();
        return view('admin.stock.add',compact('user','products','customers'));
    }

    public function save(Request $request){
       // dd($request->all());

        $errMsgs = [
            'invoice.required' => 'Please enter Invoice Number',
            'date.required' => 'Please Select Date',
        ];
        $validation_expression = [
            'invoice' => ['required','unique:stock_details'],
            'date' => ['required'],
            'invoicedate' => ['required'],
            'ref_customer' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();

            $data['invoicedate'] = date("Y-m-d", strtotime($request->invoicedate));
            $data['date'] = date("Y-m-d", strtotime($request->date));

        $item = StockDetail::create($data);
        $feature = $request->get('stock');
        $jsonString = json_encode($feature);
        $arrFeature = json_decode($jsonString);

        foreach($arrFeature as $feature):
           $stockss = Stock::create([
                'ref_product' => $feature->product,
                'quantity' => $feature->quantity,
                'ref_stock_detail' =>$item->id,
            ]);

           
              
              $productdtls=Product::where('id',$feature->product)->first();
          if(empty($productdtls->last_balance)){
            DB::table('products')->where('id', $productdtls->id)->update(['last_balance' => $productdtls->opening_balence]);
          }

          if(empty($productdtls->opening_balence)){
            DB::table('products')->where('id', $productdtls->id)->update(['opening_balence' => $feature->quantity]);
          }

          $balances=$productdtls->last_balance+$feature->quantity;

          $values = array('stocks_id' => $stockss->id,'qty_in' => $feature->quantity,'balance' => $balances,'product_id'=>$productdtls->id,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
            DB::table('order_stock_map')->insert($values);
            DB::table('products')->where('id', $productdtls->id)->update(['last_balance' => $balances]);


        endforeach;
            if($item):
                return redirect()->route('admin.stock.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }


    public function edit($id){
      $user = Auth::user();
        $item = StockDetail::find($id);
        $customers=Customer::get();
        return view('admin.stock.edit', compact('item','user','customers'));
    }


    public function update($id, Request $request){
        $errMsgs = [
            'invoice.required' => 'Please enter Invoice Number',
            'date.required' => 'Please Select Date',
        ];
        $validation_expression = [
            'invoice' => ['required','unique:stock_details'],
            'date' => ['required'],
            'invoicedate' => ['required'],
            'ref_customer' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();

            $data['invoicedate'] = date("Y-m-d", strtotime($request->invoicedate));
            $data['date'] = date("Y-m-d", strtotime($request->date));
            
            $result = StockDetail::find($id)->update($data);
            if($result):
                return redirect()->route('admin.stock.view')->with('success','Product successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

    public function delete($uid){
        
        $item = StockDetail::where('id', $uid)->first();
        $stocks= Stock::where('ref_stock_detail',$uid)->get();
        $stocks_count=$stocks->count();
        $count = 0;
        if ($stocks_count>0) {
          foreach($stocks as $stock):

        // new add  start
            $product_dtls = DB::table('products')->where('id', $stock->ref_product)->pluck('last_balance')->first();
            $productBalance= ($stock->quantity)-$product_dtls; 
            DB::table('products')->where('id', $stock->ref_product)->update(['last_balance' => $productBalance]);

            DB::table('order_stock_map')->where('stocks_id', $stock->id)->where('product_id', $stock->ref_product)->delete();
        // new add  end

            $stock->delete();
          endforeach;
        }
        if($item):
            if($item->delete()):
                return redirect()->back()->with('success','Successfully Deleted!');
            else:
                return redirect()->back()->with('error','Can\'t Deleted Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error','Item Not Found!');
    }


    public function AllStockViewPrint(Request $request){  
        //dd($request->all()); 

        $request_type = $request->datatype;

        // $from = date('Y-m-d', strtotime($request->start_date));
        $from = date('Y-m-d',strtotime('-1 months'));

        $to = date('Y-m-d', strtotime($request->end_date));
        
        $where_order = 'orders.id != 0';
        if(!empty($request->start_date)){
            $where_order .=" AND orders.date >= '$from'";
		}
        if(!empty($request->end_date)){
            $where_order .=" AND orders.date <= '$to'";
		}
        if(!empty($request->invoice)){
            $where_order .=' AND orders.invoice_number like "%'.$request->invoice.'%"';
		}
        if(!empty($request->product)){
            $where_order .=' AND products.name like "%'.$request->product.'%"';
		}
        if(!empty($request->cust_name)){
            $where_order .=' AND customers.name like "%'.$request->cust_name.'%"';
		}

        $listDataOrder = DB::table('order_details')
            ->leftJoin('orders', 'order_details.ref_order', '=', 'orders.id')
            ->join('customers', 'orders.ref_customer', '=', 'customers.id')
            ->join('products', 'order_details.ref_product', '=', 'products.id')
            ->select('order_details.id as order_details_id','order_details.ref_order as order_id','products.id as product_id','products.name as product_name','order_details.created_at as created_at','order_details.quantity as quantity_out','orders.date as date','orders.invoice_number as invoice_number','customers.name as customers_name')
            //->whereBetween('orders.date', array($from, $to))
            ->whereRaw($where_order)  
            ->orderBy('order_details.created_at','desc') 
            ->get();

        $where_stock = 'stocks.id != 0';
        if(!empty($request->start_date)){
            $where_stock .=" AND stock_details.date >= '$from'";
        }
        if(!empty($request->end_date)){
            $where_stock .=" AND stock_details.date <= '$to'";
        }
        if(!empty($request->invoice)){
            $where_stock .=' AND stock_details.invoice like "%'.$request->invoice.'%"';
        }
        if(!empty($request->product)){
            $where_stock .=' AND products.name like "%'.$request->product.'%"';
        }
        if(!empty($request->cust_name)){
            $where_stock .=' AND customers.name like "%'.$request->cust_name.'%"';
        }

        $listDataStock = DB::table('stocks')
            ->leftJoin('stock_details', 'stocks.ref_stock_detail', '=', 'stock_details.id')
            ->join('customers', 'stock_details.ref_customer', '=', 'customers.id')
            ->join('products', 'stocks.ref_product', '=', 'products.id')
            ->select('stocks.id as stocks_id','products.id as product_id','products.name as product_name','stocks.created_at as created_at','stocks.quantity as quantity_in','stock_details.date as date','stock_details.invoice as invoice_number','customers.name as customers_name')
               // ->whereBetween('stock_details.date', array($from, $to))
            ->whereRaw($where_stock) 
            ->orderBy('stocks.created_at','desc') 
            ->get();

                $results=[];
                $iii=0;
                if(!empty($listDataOrder)){
                foreach($listDataOrder as $row){
                    $results[$iii]['id']=             $row->order_details_id; 
                    $results[$iii]['product_id']=   $row->product_id;
                    $results[$iii]['product_name']=   $row->product_name;
                    $results[$iii]['quantity']=       $row->quantity_out;
                    $results[$iii]['invoice_number']= $row->invoice_number;
                    $results[$iii]['customers_name']= $row->customers_name;
                    $results[$iii]['date']=           $row->date;
                    $results[$iii]['created_at']=     $row->created_at;
                    $results[$iii]['type']= 2;

                    $iii++;
                }
                }

                if(!empty($listDataStock)){
                foreach($listDataStock as $row){

                    $results[$iii]['id']=             $row->stocks_id; 
                    $results[$iii]['product_id']=   $row->product_id;
                    $results[$iii]['product_name']=   $row->product_name;
                    $results[$iii]['quantity']=       $row->quantity_in;
                    $results[$iii]['invoice_number']= $row->invoice_number;
                    $results[$iii]['customers_name']= $row->customers_name;
                    $results[$iii]['date']=           $row->date;
                    $results[$iii]['created_at']=     $row->created_at;
                    $results[$iii]['type']= 1;

                    $iii++; 
                }
                }

                if(!empty($results)){ 
                    foreach ($results as $key => $part) {
                        $sort[$key] = strtotime($part['created_at']);
                    }
                    array_multisort($sort, SORT_ASC, $results);
                }

            $user = Auth::user();
           
        // pdf code start 
            if($request_type == "pdf"){
                //return view('pdf.stock_inout_print',compact('results','user'));
                $html = view('pdf.stock_inout_print',compact('results','user'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($html);
                return $pdf->stream();
            }
        // pdf code end
        
         // csv code start 
            if($request_type == "csv"){

                $filename = "Inout-Details-Report.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, array('Date','Invoice','Product','Customers  Dealer','Opening Balance','Quantity In','Quantity Out','Closing Balance'));
    
                if(!empty($results)){
                foreach($results as $item){ 
                    $startdate126 = date('d-m-Y', strtotime($item['created_at']));
                    $startdate124 = date('Y-m-d', strtotime($item['created_at']));
                    $startdate123 = $startdate124.' 00-00-00';
                    $startdate = date('Y-m-d', strtotime($item['created_at']. ' -1 day'));
                    $startdate = $startdate.' 00-00-00';
                    $enddate = date('Y-m-d', strtotime($item['created_at']. ' -1 day'));
                    $enddate = $enddate.' 23-59-59';
                    $today = date('Y-m-d H:i:s');
    
                    $qtyIn = '';
                    $qtyOut = '';
                    $openBalance = '';
                    $closeBalance = '';
                    if($item['type']==2) {
                        $orderdtls = DB::table('order_details')->where('id',$item['id'])->orderBy('id', 'desc')->first();
                        $closingbalance = DB::table('order_stock_map')->where('order_details_id',$item['id'])->orderBy('id', 'desc')->first();
                        $openingbalance = ($closingbalance->balance)+$item['quantity'];
                        $qtyOut = $item['quantity'];
                    } 
     
                    if($item['type']==1) {
                        $closingbalance = DB::table('order_stock_map')->where('stocks_id',$item['id'])->orderBy('id', 'desc')->first();
                        $openingbalance = ($closingbalance->balance)-$item['quantity'];
                        $qtyIn = $item['quantity'];
                    }
    
                    if(!empty($openingbalance)){
                        $openBalance = $openingbalance;
                    } 
                    if(!empty($closingbalance->balance)){
                        $closeBalance = $closingbalance->balance;
                    } 
    
                    fputcsv($handle, array($startdate126,$item['invoice_number'], $item['product_name'], $item['customers_name'], $openBalance, $qtyIn, $qtyOut, $closeBalance));
           
                }
                }
    
                fclose($handle);
                $headers = array( 'Content-Type' => 'text/csv');
    
                return response()->download($filename, "Inout-Details-Report_".date('d-m-Y').".csv", $headers);

            }
        // csv code end 

    }



}
