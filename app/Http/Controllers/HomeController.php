<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      if(Auth::check()):
          $user = Auth::user();
          //dd($user);
          switch($user->type):
              case 'admin':
                  return Redirect::route('admin.admin-dashboard');
                  break;
                  /*impliment user to do*/
              case 'employee':
                  return Redirect::route('employee.employee-dashboard');
                  break;
              case 'sales':
                  return Redirect::route('sales.sales-dashboard');
                  break;

          endswitch;
      else:
          return Redirect::route('login');
      endif;
    }
}
