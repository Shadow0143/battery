<?php
namespace App\Http\Controllers\Admin;

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

class UserController extends Controller{
    public function index(){
        $user = Auth::user();
        //$items=User::where('type', '!=' , 'admin')->orderBy('created_at', 'desc')->paginate(5);
       // $items=User::orderBy('created_at', 'desc')->paginate(5);
        $items=User::orderBy('created_at', 'desc')->get();
        return view('admin.user.index',compact('items','user'));
    }
    public function add(){
      $user = Auth::user();
        return view('admin.user.add',compact('user'));
    }
    public function save(Request $request){
        $errMsgs = [
            'name.required' => 'Please enter User Name',
            'email.required' => 'Please enter User Email',
            'password.required' => 'Please enter User Login Password',
            'type.required' => 'Please Select User Role',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required'],
            'user_type' => ['required'],  
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            $data['password'] = Hash::make($data['password']);
                $item = User::create($data);
            if($item):
                return redirect()->route('admin.user.view')->with('success','successfully created!');
            endif;
            return redirect()->back()->with('error','can\'t create, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function edit($id){
      $user = Auth::user();
        $item = User::find($id);
        return view('admin.user.edit', compact('item','user'));
    }
    public function update($id, Request $request){
      $errMsgs = [
          'name.required' => 'Please enter User Name',
          'type.required' => 'Please Select User Role',
      ];
      $validation_expression = [
          'name' => ['required', 'max:190'],
          'type' => ['required'], 
          'user_type' => ['required'],
      ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            if ($request->password) {
                if(! strlen($request->password) < 8):
                    return redirect()->back()->with('error','Password Should Be Min 8 Charector');
                else:
                    $data['password'] = Hash::make($request->password);
                endif;
            }
            $item = User::find($id)->update($data);
            if($item):
                return redirect()->route('admin.user.view')->with('success','User successfully updated!');
            endif;
            return redirect()->back()->with('error','Not updated, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function delete($uid){
        $item = User::where('id', $uid)->first();
        if($item):
            if($item->delete()):
                return redirect()->back()->with('success','Successfully Deleted!');
            else:
                return redirect()->back()->with('error','Can\'t Deleted Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error','Item Not Found!');
    }
}
