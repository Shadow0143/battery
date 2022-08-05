<?php
namespace App\Http\Controllers\Sales;

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
use PDF;
use App\Http\Controllers\ExtraController;

class OrderController extends Controller{
    public function index(){
        $user = Auth::user();
        $items=Order::with(['orderdetail','orderdetail.product','scancode','customer'])->orderBy('created_at', 'desc')->paginate(5);
        return view('sales.order.index',compact('items','user'));
    }
    public function search(Request $request)
    {
      $user = Auth::user();
      $search=$request->search;
      $items=ScanCode::where('scan_code', 'LIKE', "%{$request->input('search')}%")->with(['order','order.customer','orderdetail'])->paginate(5);
        return view('sales.order.search',compact('items','user','search'));
    }

}
