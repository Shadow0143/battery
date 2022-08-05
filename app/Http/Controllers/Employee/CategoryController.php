<?php
namespace App\Http\Controllers\Employee;

use App\Models\Category;
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

class CategoryController extends Controller{
    public function index(){
        $user = Auth::user();
        $items=Category::orderBy('created_at', 'desc')->paginate(5);
        return view('employee.category.index',compact('items','user'));
    }
    public function add(){
      $user = Auth::user();
        return view('employee.category.add',compact('user'));
    }
    public function save(Request $request){
        $errMsgs = [
            'name.required' => 'Please enter Category Name',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
                $item = Category::create($data);
            if($item):
                return redirect()->route('employee.category.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

}
