<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Product;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ExtraController;

class EmployeeController extends Controller{
    public function index(){
        $user = Auth::user();
        $product_count=Product::count();
        $customer_count=Customer::count();
        return view('employee.dashboard', compact('user','product_count','customer_count'));
    }

}
