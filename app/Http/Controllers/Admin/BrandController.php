<?php
namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ScanCode;
use App\Models\OrderDetail;
use App\Models\Stock;
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
        return view('admin.brand.index',compact('items','user'));
    }
    public function add(){
        $user = Auth::user();
        return view('admin.brand.add',compact('user'));
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
                return redirect()->route('admin.brand.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function edit($id){
        $user = Auth::user();
        $item = Brand::find($id);
        return view('admin.brand.edit', compact('item','user'));
    }
    public function update($id, Request $request){
        $errMsgs = [
            'name.required' => 'Please enter Title',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
                $result = Brand::find($id)->update($data);
            if($result):
                return redirect()->route('admin.brand.view')->with('success','Brand successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function delete($uid){
        $item = Brand::where('id', $uid)->first();
        $products= Product::where('ref_brand',$uid)->get();
        $products_count=$products->count();
        $count = 0;
        if ($products_count>0) {
            return redirect()->back()->with('error','You can\'t delete the brand as products of this brand are present!')->withInput();
        }
        if($item):
            if($item->delete()):
                return redirect()->back()->with('success','Successfully Deleted!');
            else:
                return redirect()->back()->with('error','Can\'t Deleted Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error','User Not Found!');
    }
}
