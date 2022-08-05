<?php
namespace App\Http\Controllers\Employee;

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

class ProfileController extends Controller{
    public function ChangePasswordView(){
        $user = Auth::user();
        return view('employee.profile.change-password',compact('user'));
    }
    public function ChangePasswordSave(Request $request){
      $user = Auth::user();
        $errMsgs = [
            'password.required' => 'Please Enter Password',
        ];
        $validation_expression = [
            'password' => ['required', 'min:6']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if(!$validator->fails()):
            $data = $validator->validate();
            $data['password']= Hash::make($data['password']);
                $item = User::find($user->id)->update($data);
            if($item):
                return redirect()->back()->with('success','successfully Changed Your Password!');
            endif;
            return redirect()->back()->with('error','can\'t Change, please try again!')->withInput();
        else:
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }

}
