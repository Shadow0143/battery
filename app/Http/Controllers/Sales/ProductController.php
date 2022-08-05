<?php
namespace App\Http\Controllers\Sales;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
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
use App\Http\Controllers\ExtraController;

class ProductController extends Controller{
    public function index(){
      $user = Auth::user();
        $items=Product::with(['brand','category'])->orderBy('created_at', 'desc')->paginate(5);
        return view('sales.product.index',compact('items','user'));
    }

}
