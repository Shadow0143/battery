<?php
namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ScanCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class BarcodeController extends Controller{
    public function add($id){
      $user = Auth::user();
      $order_detail_id=$id;
      $products=Product::get();
      return view('admin.bar-code.add',compact('user','order_detail_id','products'));
    }

    public function save(Request $request,$id){
        //dd($request->all());

        $errMsgs = [
            'scan_code.required' => 'Please Type Bar Code',
        ];
        $validation_expression = [
            'scan_code' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
          $data = $validator->validate();
          $order_detail=OrderDetail::find($id);
          $data['ref_order_details']=$id;
          $data['ref_order']=$order_detail->ref_order;

          $order_detail['quantity'] = ($order_detail->quantity)+1;
          $order_detail->save();
          $item = ScanCode::create($data);

        $getProductBalance = DB::table('products')->where('id', $order_detail->ref_product)->pluck('last_balance')->first();
        DB::table('products')->where('id', $order_detail->ref_product)->update(['last_balance' => ($getProductBalance-1)]);

        $getOrder_stock_map = DB::table('order_stock_map')->select('qty_out','balance')->where('product_id', $order_detail->ref_product)->where('order_details_id', $order_detail->id)->first();
            $quantity_out = ($getOrder_stock_map->qty_out)+1;
            $balance = ($getOrder_stock_map->balance)-1;

         DB::table('order_stock_map')->where('product_id', $order_detail->ref_product)->where('order_details_id', $order_detail->id)->update(['qty_out' => $quantity_out , 'balance' => $balance]);

            if($item):
                return redirect()->back()->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

    public function edit($id){
      $user = Auth::user();
        $item = ScanCode::find($id);
        return view('admin.bar-code.edit', compact('item','user'));
    }
    public function update($id, Request $request){
        $errMsgs = [
            'scan_code.required' => 'Please Type Bar Code',
        ];
        $validation_expression = [
            'scan_code' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            $item = ScanCode::find($id)->update($data);
            if($item):
                return redirect()->back()->with('success','#'.$id.' successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

    public function delete($id){
       
        $item = ScanCode::where('id', $id)->first();

        $order_detail = OrderDetail::where('id', $item->ref_order_details)->where('ref_order', $item->ref_order)->first();
        $order_detail['quantity'] = ($order_detail->quantity)-1;
        $order_detail->save();
       
        $getProductBalance = DB::table('products')->where('id', $order_detail->ref_product)->pluck('last_balance')->first();
        DB::table('products')->where('id', $order_detail->ref_product)->update(['last_balance' => ($getProductBalance+1)]);

        $getOrder_stock_map = DB::table('order_stock_map')->select('qty_out','balance')->where('product_id', $order_detail->ref_product)->where('order_details_id', $order_detail->id)->first();
            $quantity_out = ($getOrder_stock_map->qty_out)-1;
            $balance = ($getOrder_stock_map->balance)+1;

        DB::table('order_stock_map')->where('product_id', $order_detail->ref_product)->where('order_details_id', $order_detail->id)->update(['qty_out' => $quantity_out , 'balance' => $balance]);

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
