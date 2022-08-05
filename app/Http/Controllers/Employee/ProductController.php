<?php
namespace App\Http\Controllers\Employee;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
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

class ProductController extends Controller{
    public function index(){
      $user = Auth::user();
        $items=Product::with(['brand','category'])->orderBy('created_at', 'desc')->paginate(5);
        return view('employee.product.index',compact('items','user'));
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
     
        return view('employee.product.barcode',compact('customers','products','scandetails','orders','user'));
    }

    public function add(){
      $user = Auth::user();
      $categories=Category::get();
      $brands=Brand::get();
        return view('employee.product.add',compact('user','categories','brands'));
    }
    public function save(Request $request){
        // dd($request);
        $errMsgs = [
            'name.required' => 'Please enter Product Name',
            'ref_category.required' => 'Please Select Product Category',
            'ref_brand.required' => 'Please Select Product Brand',
        ];
        $validation_expression = [
            'name' => ['required'],
            'ref_category' => ['required'],
            'ref_brand' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            if ($request->code) {
              $data['code'] =$request->code;
            }
            if($request->opening_balence){
                $data['opening_balence']= $request->opening_balence;
            }

            $item = Product::create($data);
            if($item):
                return redirect()->route('employee.product.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

}
