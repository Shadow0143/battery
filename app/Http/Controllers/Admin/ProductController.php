<?php
namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Stock;
use App\Models\OrderDetail;
use App\Models\ScanCode;
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

class ProductController extends Controller{
    public function index(){
      $user = Auth::user();
        // $items=Product::with(['brand','category'])->orderBy('created_at', 'desc')->paginate(5);
        $items=Product::with(['brand','category'])->orderBy('created_at', 'desc')->get();
        return view('admin.product.index',compact('items','user'));
    }

      public function serachbarcode(){
         $input  = \Request::get('barcode');
        // echo  $input;die;
       $user = Auth::user();
      //  $items=Product::with(['brand','category'])->orderBy('created_at', 'desc')->paginate(5);
       $scandetails=  DB::table('sacn_codes')->where('scan_code','=',$input)->first();
        
        if(!empty($scandetails)){
         $order_details=  DB::table('order_details')->where('id','=',$scandetails->ref_order_details)->first();
        $orders=  DB::table('orders')->where('id','=',$scandetails->ref_order)->first();

        $customers=  DB::table('customers')->where('id','=',$orders->ref_customer)->first();
        $products=  DB::table('products')->where('id','=',$order_details->ref_product)->first();
 
        }else{
            $customers='';
            $products='';
            $scandetails='';
        }
     
        return view('admin.product.barcode',compact('customers','products','scandetails','orders','user'));
    }


     public function add(){
      $user = Auth::user();
      $categories=Category::get();
      $brands=Brand::get();
        return view('admin.product.add',compact('user','categories','brands'));
    }
    public function save(Request $request){
        // dd($request);
        $errMsgs = [
            'name.required' => 'Please enter Product Name'
           // 'ref_category.required' => 'Please Select Product Category',
           // 'ref_brand.required' => 'Please Select Product Brand',
        ];
        $validation_expression = [
            'name' => ['required']
           // 'ref_category' => ['required'],
            // 'ref_brand' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            if ($request->code) {
              $data['code'] =$request->code;
            }
            if($request->opening_balence){
                $data['opening_balence']= $request->opening_balence;
                $data['last_balance']= $request->opening_balence;
            }
            $item = Product::create($data);


          /*  $values = array('qty_in' => $request->opening_balence,'balance' => $request->opening_balence,'product_id'=>$item->id,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
            DB::table('order_stock_map')->insert($values);
            */


            if($item):
                return redirect()->route('admin.product.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function edit($id){
      $user = Auth::user();
      $categories=Category::get();
      $brands=Brand::get();
        $item = Product::where('id', $id)->first();
        return view('admin.product.edit', compact('item','user','categories','brands'));
    }

    public function update($id, Request $request){
       // dd($request->all());

        $errMsgs = [
            'name.required' => 'Please enter Title',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            if ($request->code) {
              $data['code'] =$request->code;
            }
            if ($request->ref_category) {
              $data['ref_category'] =$request->ref_category;
            }
            if ($request->ref_brand) {
              $data['ref_brand'] =$request->ref_brand;
            }
            //if($request->opening_balence){
                $data['opening_balence']= $request->opening_balence;
           // }

        // new add  start
            $balence1 = 0;
            $totalBalence = 0;
            $productdtls=Product::where('id',$id)->first();
            $lastBalence = $productdtls->last_balance;
            $balence1 = $lastBalence - $request->oldbalence;
            $totalBalence = $balence1 + $request->opening_balence;
            
            $data['last_balance']= $totalBalence;
        // new add  end

            $result = Product::find($id)->update($data);

        // new add  start
          //   DB::table('order_stock_map')->where('product_id', $id)->update(['qty_in' => $request->opening_balence , 'balance' => $totalBalence]);
      
        // new add  end


            if($result):
                return redirect()->route('admin.product.view')->with('success','Product successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

    public function delete($uid){
        $item = Product::where('id', $uid)->first();
        $stocks=Stock::where('ref_product',$uid)->get();
            $stocks_count=$stocks->count();
            if($stocks_count>0){
                foreach($stocks as $stock):
                    $stock->delete();
                endforeach;
            }
        $order_details= OrderDetail::where('ref_product',$uid)->get();
        $order_detail_count=$order_details->count();
        $count = 0;
        if ($order_detail_count>0) {
          foreach($order_details as $order_detail):
            $scan_codes=ScanCode::where('ref_order_details',$order_detail->id)->get();
            $scan_code_count=$scan_codes->count();
              if ($scan_code_count>0) {
                foreach($scan_codes as $scan_code):
                  $scan_code->delete();
                endforeach;
              }
              $order_detail->delete();
          endforeach;
        }
        if($item):
            if($item->delete()):
                return redirect()->back()->with('success','Successfully Deleted!');
            else:
                return redirect()->back()->with('error','Can\'t Deleted Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error','User Not Found!');
    }

    public function print(){
       
        $products=Product::with(['brand','category'])->orderBy('created_at', 'desc')->get();
        
         $html = view('pdf.product_print',compact('products'))->render();
         $pdf = \App::make('dompdf.wrapper');
         $pdf->loadHTML($html);
         return $pdf->stream();
    }

    public function csvDownload(){
       
        $products=Product::with(['brand','category'])->orderBy('created_at', 'desc')->get();
      
            $filename = "Product_List_Report.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('Product Name','Current Balance'));

            if(!empty($products)){
            foreach($products as $row){ 
              
                fputcsv($handle, array($row->name, $row->last_balance));
                
            }
            }

            fclose($handle);
            $headers = array( 'Content-Type' => 'text/csv');

        return response()->download($filename, "Product_List_Report_".date('d-m-Y').".csv", $headers);

    }


}
