<?php
namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ScanCode;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ExtraController;
use DB;
   
class OrderdetailsController extends Controller{
    public function add($id){
      $user = Auth::user();
      $order_id=$id;
      $products=Product::get();
      return view('admin.order-details.add',compact('user','order_id','products'));
    }

    public function save(Request $request,$id){
    //    dd($request->all(),$id);

        $errMsgs = [
            'product.required' => 'Please select Product',
            'quantity.required' => 'Please Type Quantity',
            'scan_code.required' => 'Please select Bar Code',
        ];
        $validation_expression = [
            'product' => ['required'],
            'quantity' => ['required'],
            'scan_code' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $products=$request->product;
            for($i=0; $i < count($request->product); $i++) {
              $scan_codes=$request->scan_code[$i];
              $order_detail=OrderDetail::create([
                    'ref_order' => $id,
                    'ref_product' => $request->product[$i],
                    'quantity'=>$request->quantity[$i],
                ]);
                foreach($scan_codes as $scan_code):
                  ScanCode::create([
                    'scan_code' => $scan_code,
                    'ref_order_details' => $order_detail->id,
                    'ref_order' => $id,
                  ]);
                endforeach;

                // add new code start
                    $productdtls=Product::where('id',$request->product[$i])->first();
                    if(empty($productdtls->last_balance)){
                        DB::table('products')->where('id', $productdtls->id)->update(['last_balance' => $productdtls->opening_balence]);
                    }
        
                    $productdtls=Product::where('id',$request->product[$i])->first();
                    $balances=$productdtls->last_balance-$request->quantity[$i];
        
                    $values = array('order_details_id' => $order_detail->id,'qty_out' => $request->quantity[$i],'balance' => $balances,'product_id'=>$productdtls->id,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
                        DB::table('order_stock_map')->insert($values);
                        DB::table('products')->where('id', $productdtls->id)->update(['last_balance' => $balances]);
                // add new code end

            }

            if(!$validator->fails()):
                return redirect()->back()->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    
    public function edit($id){
      $user = Auth::user();
        $item = OrderDetail::find($id);
        $customers=Customer::get();
        $products=Product::get();
        return view('admin.order-details.edit', compact('item','user','customers','products'));
    }
    public function update($id, Request $request){
        $errMsgs = [
            'ref_product.required' => 'Please Select Product',
            'quantity.required' => 'Please Type Quantity',
        ];
        $validation_expression = [
            'ref_product' => ['required'],
            'quantity' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            // dd($data);
            $item = OrderDetail::find($id)->update($data);
            if($item):
                return redirect()->back()->with('success','#'.$id.' successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

    public function delete($id){
       
        $item = OrderDetail::where('id', $id)->first();
        $scan_codes=ScanCode::where('ref_order_details',$id)->get();
        $scan_code_count=$scan_codes->count();
        if ($scan_code_count>0) {
          foreach($scan_codes as $scan_code):
              $scan_code->delete();
          endforeach;
          
          $getProductBalance = DB::table('products')->where('id', $item->ref_product)->pluck('last_balance')->first();
          $ProductBalanceQty = $getProductBalance + $item->quantity;
            DB::table('products')->where('id', $item->ref_product)->update(['last_balance' => $ProductBalanceQty]);
            DB::table('order_stock_map')->where('product_id', $item->ref_product)->where('order_details_id', $item->id)->delete();

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
