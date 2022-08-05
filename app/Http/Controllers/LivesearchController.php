<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LivesearchController extends Controller{
    public function invoiceNumber(Request $request)
    {
        $items=OrderDetail::where('ref_product',$request->id)->pluck('ref_order')->toArray();
        $old_orders=Order::whereIn('id',$items);
        if($request->SearchInvoice){
            $invoice=$request->SearchInvoice;
            $old_orders->where('invoice_number', 'like', $invoice . '%');
        }
        // if(!$request->EndDate):
        //     $endDate=null;
        // else:
        //     $endDate=$request->EndDate;
        // endif;
        // if(!$request->StartDate):
        //     $StartDate=null;
        // else:
        //     $StartDate=$request->StartDate;
        // endif;
        // $old_orders->whereBetween('date', [$StartDate, $endDate]);
        $orders=$old_orders->get();
       response()->json($orders);
       return view('live-search.orders-details',compact('orders'));
    }
    public function DateBetten(Request $request){

        $items=OrderDetail::where('ref_product',$request->id)->pluck('ref_order')->toArray();
        $old_orders=Order::whereIn('id',$items);
        if($request->SearchInvoice){
            $invoice=$request->SearchInvoice;
            $old_orders->where('invoice_number', 'like', $invoice . '%');
        }
        if(!$request->EndDate):
            $endDate=Carbon::today()->toDateString();
        else:
            $endDate=$request->EndDate;
        endif;
        if(!$request->StartDate):
            $StartDate=Carbon::today()->toDateString();
        else:
            $StartDate=$request->StartDate;
        endif;
        $old_orders->whereBetween('date', [$StartDate, $endDate]);
        $orders=$old_orders->get();
       response()->json($orders);
       return view('live-search.orders-details',compact('orders'));
    }
    public function Pagination(Request $request){
        $items=Category::orderBy('created_at', 'desc')->paginate($request->Select);
        response()->json($items);
       return view('admin.category.filter',compact('items'));
    }
}
