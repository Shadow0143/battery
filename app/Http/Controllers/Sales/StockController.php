<?php
namespace App\Http\Controllers\Sales;

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
     public function AllStock()
    {
      $user = Auth::user();
      $items=Product::paginate(10);
      return view('sales.all-stock.index',compact('items','user'));
    }
    public function searchAllStock(Request $request)
    {
        $user = Auth::user();
      $search=$request->search;
      $items=Product::where('name', 'LIKE', "%{$request->input('search')}%")->paginate(10);
        return view('sales.all-stock.search',compact('items','user','search'));
    }
    public function AllStockDetails($id){
        $AjaxId=$id;
     $user = Auth::user();
     $items=OrderDetail::where('ref_product',$id)->paginate(10);
     return view('sales.all-stock.details',compact('items','user','AjaxId'));
    }
}
