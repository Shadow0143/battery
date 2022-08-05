<?php
namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
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
use PDF;
use App\Http\Controllers\ExtraController;

class OrderController extends Controller{

    public function index(){
        $user = Auth::user();
        //$items=Order::with(['orderdetail','orderdetail.product','scancode','customer'])->orderBy('created_at', 'desc')->paginate(5);
        $items=Order::with(['orderdetail','orderdetail.product','scancode','customer'])->orderBy('created_at', 'desc')->get();
        return view('admin.order.index',compact('items','user'));
    }

    public function search(Request $request)
    {
      $user = Auth::user();
      $search=$request->search;
     // $items=ScanCode::where('scan_code', 'LIKE', "%{$request->input('search')}%")->with(['order','order.customer','orderdetail'])->paginate(5);
      $items=ScanCode::where('scan_code', 'LIKE', "%{$request->input('search')}%")->with(['order','order.customer','orderdetail'])->get();
       
      return view('admin.order.search',compact('items','user','search'));
    }

    public function add(){

      $user = Auth::user();
      $customers=Customer::get();
      $products=Product::get();
      $scancodes1 = ScanCode::pluck('scan_code')->toArray();
      $scancodes = implode(',',$scancodes1);
     // echo '<pre>'; echo($scancodes);die;
      return view('admin.order.add',compact('user','customers','products','scancodes'));
    }

    public function save(Request $request){
        // dd($request->all());

        for($i=0; $i < count($request->product); $i++) {
            if(! $request->scan_code[$i]){
              return redirect()->back()->with('error','Please Type Scan Code!');
            }

              // add code scan check start
              if( $request->scan_check[$i] == 0){
              // add code scan check end

                $scan_codes=$request->scan_code[$i];
                foreach($scan_codes as $scan_code):
                  $existing_scan_code=ScanCode::where('scan_code',$scan_code)->count();
                  if(1<=$existing_scan_code){
                      return redirect()->back()->with('error','#'.$scan_code.' Bar Code Already Exigist');
                  }
                endforeach;
              }

          }

        $errMsgs = [
            'ref_customer.required' => 'Please select Customer',
            'invoice_number.required' => 'Please Enter No.',
            'date.required' => 'Please select Date',
        ];

        $validation_expression = [
            'ref_customer' => ['required'],
            'invoice_number' => ['required','unique:orders'],
           // 'bill_number' => ['required'],
            'date' => ['required']
            //'phone_number'=> ['nullable'],
            //'address'=> ['nullable']
        ];

        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);

        if(!$validator->fails()):
            $data = $validator->validate();

            $data['date'] = date("Y-m-d", strtotime($request->date));
            $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));
            
            $item = Order::create($data);
            $products=$request->product;

            for($i=0; $i < count($request->product); $i++) {
              if(! $request->scan_code[$i]){
                return redirect()->back()->with('error','Please Type Scan Code!');
              }
                $scan_codes=$request->scan_code[$i];

              $order_detail=OrderDetail::create([
                    'ref_order' => $item->id,
                    'ref_product' => $request->product[$i],
                    'quantity'=>$request->quantity[$i],
                ]);


          $productdtls=Product::where('id',$request->product[$i])->first();
          if(empty($productdtls->last_balance)){
            DB::table('products')->where('id', $productdtls->id)->update(['last_balance' => $productdtls->opening_balence]);
          }

          $productdtls=Product::where('id',$request->product[$i])->first();
          $balances=$productdtls->last_balance-$request->quantity[$i];

          $values = array('order_details_id' => $order_detail->id,'qty_out' => $request->quantity[$i],'balance' => $balances,'product_id'=>$productdtls->id,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
            DB::table('order_stock_map')->insert($values);
            DB::table('products')->where('id', $productdtls->id)->update(['last_balance' => $balances]);

                foreach($scan_codes as $scan_code):
                  ScanCode::create([
                    'scan_code' => $scan_code,
                    'ref_order_details' => $order_detail->id,
                    'ref_order' => $item->id,
                  ]);
                endforeach;
            }


            


            $pdf_order_details=OrderDetail::where('ref_order',$item->id)->get();
            
           // echo '<pre>'; print_r($scancode_list);die;
            $client=Customer::find($item->ref_customer);
            $html = view('pdf.invoice',compact('item','pdf_order_details','client'))->render();
            //$file_name=str_replace(' ', '', strtolower($user->name)).'_'.$request->input('job').'_'.$ref_id.'.pdf';
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            // Redirect::away($url)
           
           // return $pdf->stream();
            if($item):
                return redirect()->route('admin.order.view')->with('success','Successfully created!');
                //return redirect()->back()->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }



     public function reprint($id){
      //$user = Auth::user();
        $item = Order::find($id);
        $client=Customer::find($item->ref_customer);
         $pdf_order_details=OrderDetail::where('ref_order',$item->id)->get();
       // $products=Product::get();
        $html = view('pdf.invoice',compact('item','pdf_order_details','client'))->render();
            //$file_name=str_replace(' ', '', strtolower($user->name)).'_'.$request->input('job').'_'.$ref_id.'.pdf';
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            // Redirect::away($url)
            return $pdf->stream();
    }



    public function edit($id){
      $user = Auth::user();
        $item = Order::find($id);
        $customers=Customer::get();
        $products=Product::get();
        return view('admin.order.edit', compact('item','user','customers','products'));
    }

    public function update($id, Request $request){
      //dd($request->all());
      
        $errMsgs = [
            'ref_customer.required' => 'Please enter Title',
        ];

        $ordersData = Order::select('invoice_number')->where('id' ,$id)->first();
        if($ordersData->invoice_number == $request->invoice_number){
          $validation_expression = [
            'ref_customer' => ['required'],
            'date' => ['required']
          ];
        }else{
          $validation_expression = [
            'ref_customer' => ['required'],
            'invoice_number' => ['required','unique:orders'],
            //'bill_number' => ['required'],
            'date' => ['required']
            //'phone_number'=> ['nullable'],
            //'address'=> ['nullable']
        ];
        }
        
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();

            $data['date'] = date("Y-m-d", strtotime($request->date));
            $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));
            
            $item = Order::find($id)->update($data);
            if($item):
                return redirect()->back()->with('success','#'.$id.' successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

    public function delete($id){
     
        $item = Order::where('id', $id)->first();
        
        $order_details=OrderDetail::where('ref_order',$id)->get();
        $scan_codes=ScanCode::where('ref_order',$id)->get();
        $scan_code_count=$scan_codes->count();

        if ($scan_code_count>0) {
          foreach($scan_codes as $scan_code):
              $scan_code->delete();
          endforeach;

        $order_detail_count=$order_details->count();
        $count = 0;
        if ($order_detail_count>0) {
          foreach($order_details as $order_detail):

            $product_dtls = DB::table('products')->where('id', $order_detail->ref_product)->pluck('last_balance')->first();
              $productBalance= ($order_detail->quantity)+$product_dtls; 
              DB::table('products')->where('id', $order_detail->ref_product)->update(['last_balance' => $productBalance]);

              DB::table('order_stock_map')->where('order_details_id', $order_detail->id)->where('product_id', $order_detail->ref_product)->delete();

          $order_detail->delete();

          endforeach;
        }

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

}
