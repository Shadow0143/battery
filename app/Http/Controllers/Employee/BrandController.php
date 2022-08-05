<?php
namespace App\Http\Controllers\Employee;

use App\Models\Brand;
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

class BrandController extends Controller{
    public function index(){
        $user = Auth::user();
        $items=Brand::orderBy('created_at', 'desc')->paginate(5);
        return view('employee.brand.index',compact('items','user'));
    }
    public function add(){
        $user = Auth::user();
        return view('employee.brand.add',compact('user'));
    }
    public function save(Request $request){
        $errMsgs = [
            'name.required' => 'Please enter Title',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
                $item = Brand::create($data);
            if($item):
                return redirect()->route('employee.brand.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
}
