<?php
namespace App\Http\Controllers\Employee;

use App\Models\StockDetail;
use App\Models\Product;
use App\Models\Stock;
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

class StockController extends Controller{
    public function index(){
      $user = Auth::user();
      $products=Product::get();
        $items=StockDetail::orderBy('created_at', 'desc')->paginate(10);
        return view('employee.stock.index',compact('items','user','products'));
    }
     public function AllStock()
    {
      $user = Auth::user();
      $items=Product::paginate(10);
      return view('employee.all-stock.index',compact('items','user'));
    }
    public function searchAllStock(Request $request)
    {
        $user = Auth::user();
      $search=$request->search;
      $items=Product::where('name', 'LIKE', "%{$request->input('search')}%")->paginate(10);
        return view('employee.all-stock.search',compact('items','user','search'));
    }
    public function AllStockDetails($id){
        $AjaxId=$id;
        $user = Auth::user();
     $items=OrderDetail::where('ref_product',$id)->paginate(10);
     return view('employee.all-stock.details',compact('items','user','AjaxId'));
    }
    public function add(){
      $user = Auth::user();
      $products=Product::get();
        return view('employee.stock.add',compact('user','products'));
    }
    public function save(Request $request){
        $errMsgs = [
            'invoice.required' => 'Please enter Invoice Number',
            'date.required' => 'Please Select Date',
        ];
        $validation_expression = [
            'invoice' => ['required'],
            'date' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
        $item = StockDetail::create($data);
        $feature = $request->get('stock');
        $jsonString = json_encode($feature);
        $arrFeature = json_decode($jsonString);

        foreach($arrFeature as $feature):
            Stock::create([
                'ref_product' => $feature->product,
                'quantity' => $feature->quantity,
                'ref_stock_detail' =>$item->id,
            ]);
        endforeach;
            if($item):
                return redirect()->route('employee.stock.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

}
