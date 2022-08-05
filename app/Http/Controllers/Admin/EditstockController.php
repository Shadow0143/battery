<?php
namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Stock;
use App\Models\ScanCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use DB;

class EditstockController extends Controller{
    public function add($id){
      $user = Auth::user();
      $stock_details_id=$id;
      return view('admin.edit-stock.add',compact('user','stock_details_id'));
    }

    public function save(Request $request,$id){
       // dd($request->all());

        $errMsgs = [
            'ref_product.required' => 'Please Select Product',
            'quantity.required' => 'Please Type Quantity',
        ];
        $validation_expression = [
            'ref_product' => ['required'],
            'quantity' => ['required']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
          $data = $validator->validate();
          $data['ref_stock_detail']=$id;
          $item = Stock::create($data);

        // new add  start
           $productdtls=Product::where('id',$request->ref_product)->first();
            
           $totalBalence = 0;
           $lastBalence = $productdtls->last_balance;
           $totalBalence = $lastBalence + $request->quantity;
           
           $productdtls->last_balance = $totalBalence;
           $productdtls->save();

           $values = array('stocks_id' => $item->id,'qty_in' => $request->quantity,'balance' => $totalBalence,'product_id'=>$request->ref_product,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"));
           DB::table('order_stock_map')->insert($values);
          // new add  end

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
        $item = Stock::find($id);
        return view('admin.edit-stock.edit', compact('item','user'));
    }

    public function update($id, Request $request){
          //dd($request->all());

        $errMsgs = [
            'ref_product.required' => 'Please Select Product',
            'quantity.required' => 'Please Type Quantity',
        ];
        $validation_expression = [
            'ref_product' => ['required'],
            'quantity' => ['required']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            // dd($id,$data);
            $item = Stock::find($id)->update($data);

                $productdtls=Product::where('id',$request->ref_product)->first();

                // dd($productdtls->last_balance,$request->oldQuantity,$request->quantity,$id);

                $balence1 = 0;
                $totalBalence = 0;
                $lastBalence = $productdtls->last_balance;
                $balence1 = $lastBalence - $request->oldQuantity;
                $totalBalence = $balence1 + $request->quantity;
                
                $productdtls->last_balance = $totalBalence;
                $productdtls->save();

                DB::table('order_stock_map')->where('product_id', $request->ref_product)->where('stocks_id', $id)->update(['qty_in' => $request->quantity , 'balance' => $totalBalence]);
                // new add  end

            if($item):
                return redirect()->back()->with('success','#'.$id.' successfully updated!');
            endif;
                return redirect()->back()->with('error','Not updated, please try again!')->withInput();
            else:
                return redirect()->back()->withErrors($validator->errors())->withInput();
            endif;
    }

    public function delete($id){
        
        $item = Stock::where('id', $id)->first();

        if($item):
  
        // new add  start
            $productdtls=Product::where('id',$item->ref_product)->first();

                $totalBalence = 0;
                $lastBalence = $productdtls->last_balance;
                $totalBalence = $lastBalence - $item->quantity;

            $productdtls->last_balance = $totalBalence;
            $productdtls->save();

          DB::table('order_stock_map')->where('stocks_id', $item->id)->where('product_id', $item->ref_product)->delete();
        // new add  end

            if($item->delete()):
                return redirect()->back()->with('success','Successfully Deleted!');
            else:
                return redirect()->back()->with('error','Can\'t Deleted Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error','Item Not Found!');
    }


    
}
