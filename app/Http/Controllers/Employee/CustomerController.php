<?php
namespace App\Http\Controllers\Employee;

use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\order;
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

class customerController extends Controller{
    public function index(){
        $user = Auth::user();
        $items=customer::orderBy('created_at', 'desc')->paginate(5);
        return view('employee.customer.index',compact('items','user'));
    }
    public function add(){
        $user = Auth::user();
        return view('employee.customer.add',compact('user'));
    }
    public function save(Request $request){
        $errMsgs = [
            'name.required' => 'Please Enter Customer Name',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            if ($request->company_name) {
            $data['company_name']=$request->company_name;
            }
            if ($request->phone) {
            $phone_length=strlen($request->phone);
            if ($phone_length>10) {
              return redirect()->back()->with('error','Phone Number Must Be 10 Digit!');
            }
            if ($phone_length<10) {
              return redirect()->back()->with('error','Phone Number Must Be 10 Digit!');
            }
            if ($phone_length=10) {
              $data['phone']=$request->phone;
            }
            }
            if ($request->email) {
              if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    return redirect()->back()->with('error','Your Email Address Is Invalid!');
                }
                $data['email']=$request->email;
            }
            if ($request->city) {
            $data['city']=$request->city;
            }
            if ($request->state) {
            $data['state']=$request->state;
            }
            if ($request->country) {
            $data['country']=$request->country;
            }
            if ($request->pin) {
              $pin_length=strlen($request->pin);
              if ($pin_length>6) {
                return redirect()->back()->with('error','Pin Code Must Be 6 Digit!');
              }
              if ($pin_length<6) {
                return redirect()->back()->with('error','Pin Code Must Be 6 Digit!');
              }
              if ($pin_length=6) {
                $data['pin']=$request->pin;
              }
            }
            if ($request->address) {
            $data['address']=$request->address;
            }
            if ($request->gst) {
              if(!preg_match("/^([0-5]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([a-zA-Z0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/", $request->gst)) {
                return redirect()->back()->with('error','Your GST Format Is Invalid!');
              }
              $data['gst']=$request->gst;
            }
            $item = customer::create($data);
            if($item):
                return redirect()->route('employee.customer.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

}
