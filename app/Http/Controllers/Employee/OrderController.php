<?php
namespace App\Http\Controllers\Employee;

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
        return view('employee.order.index',compact('items','user'));
    }
    public function search(Request $request)
    {
      $user = Auth::user();
      $search=$request->search;
      $items=ScanCode::where('scan_code', 'LIKE', "%{$request->input('search')}%")->with(['order','order.customer','orderdetail'])->paginate(5);
        return view('employee.order.search',compact('items','user','search'));
    }
    public function add(){
      $user = Auth::user();
      $customers=Customer::get();
      $products=Product::get();
      return view('employee.order.add',compact('user','customers','products'));
    }
    public function save(Request $request){
        for($i=0; $i < count($request->product); $i++) {
            if(! $request->scan_code[$i]){
                return redirect()->back()->with('error','Please TYpe Scan Code!');
              }
            $scan_codes=$request->scan_code[$i];
              foreach($scan_codes as $scan_code):
                $existing_scan_code=ScanCode::where('scan_code',$scan_code)->count();
                if(1<=$existing_scan_code){
                    return redirect()->back()->with('error','#'.$scan_code.' Bar Code Already Exigist');
                }
              endforeach;
          }
        $errMsgs = [
            'ref_customer.required' => 'Please select Customer',
            'invoice_number.required' => 'Please select Customer',
            'date.required' => 'Please select Customer',
        ];
        $validation_expression = [
            'ref_customer' => ['required'],
            'invoice_number' => ['required','unique:orders'],
            'date' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            $item = Order::create($data);
            $products=$request->product;

            for($i=0; $i < count($request->product); $i++) {
              if(! $request->scan_code[$i]){
                return redirect()->back()->with('error','Please TYpe Scan Code!');
              }
                $scan_codes=$request->scan_code[$i];
              $order_detail=OrderDetail::create([
                    'ref_order' => $item->id,
                    'ref_product' => $request->product[$i],
                    'quantity'=>$request->quantity[$i],
                ]);
                foreach($scan_codes as $scan_code):
                  ScanCode::create([
                    'scan_code' => $scan_code,
                    'ref_order_details' => $order_detail->id,
                    'ref_order' => $item->id,
                  ]);
                endforeach;
            }
            $pdf_order_details=OrderDetail::where('ref_order',$item->id)->get();
            $client=Customer::find($item->ref_customer);
            $html = view('pdf.invoice',compact('item','pdf_order_details','client'))->render();
            //$file_name=str_replace(' ', '', strtolower($user->name)).'_'.$request->input('job').'_'.$ref_id.'.pdf';
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            // Redirect::away($url)
            return $pdf->stream();

            if($item):
                return redirect()->back()->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

}
