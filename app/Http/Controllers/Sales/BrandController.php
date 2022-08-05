<?php
namespace App\Http\Controllers\Sales;

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
        return view('sales.brand.index',compact('items','user'));
    }

}
