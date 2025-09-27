<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductViewed;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use DB;

class FrontendController extends Controller
{
    public function home()
    {
        $featuredProduct = Product::where('isFeatured' ,'=',1)->latest()->paginate(8);
        $first = Product::first();
        $deals_weak = Product::latest()->paginate(3);
        $categories = Category::all();
        $hotSale = Product::where('oldPrice','!=',null)->latest()->paginate(8);
        $ip = $_SERVER['REMOTE_ADDR'];

        $view = DB::table('product_vieweds')->where('ip','=',$ip)
            ->join('products','product_vieweds.product_id','=','products.id')
            ->select('products.*')
            ->latest()->paginate(6);

        return view('frontend.index', compact('featuredProduct', 'first', 'deals_weak','categories','hotSale','view'));
    }

    public function userLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = $request->all();

            if (Auth::guard('web')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
                $user = User::where('email', $check['email'])->first();
                if (Auth::user()->hasRole('admin')) {
                    Auth::login($user);
                    return response()->json(['data' => 1]); //Admin login successful
                } else {
                    Auth::login($user);
                    return response()->json(['data' => 2]); //User login successful
                }
            } else {
                return response()->json(['data' => 0]); //Email or password is incorrect
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function newAccount(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = User::where('email', '=', $request->email)->first();
            if (isset($check)) {
                return response()->json(['data' => 0]); // email already exist. try another email
            } else {
                $user = new User();
                $user->name = strip_tags($request->name);
                $user->email = strip_tags($request->email);
                $user->password = Hash::make($request->password);
                $user->created_at = Carbon::now();
                $user->save();

                $user->assignRole('user');
                Auth::login($user);

                return response()->json(['data' => 1]); //create successfully
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function userLogOut()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('home');
    }

    public function userForgetPassword()
    {
        return view('/auth/forgot-password');
    }
    public function userResetPassword()
    {
        $check = User::where('email', '=', request()->email)->first();
        if (isset($check)) {
            $url = route('userUpdatePassword', ['id' => $check->id]);
            Mail::to($check->email)->send(new ForgetPassword($url));
            //return view('/auth/reset-password');
        }else{
            return response()->json(['data' => 0]);
        }
    }

    public function userUpdatePassword($id)
    {
        $user = User::findOrFail($id);
        return view('/auth/update-password', compact('user'));
    }

    public function userUpdatedPassword(Request $request)
    {
        if ($request->isMethod('post')) {

            $updated = User::where('id', $request->userID)->update([
                'password' => Hash::make($request->password),
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password updated successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or password not changed'
                ]);
            }

        } else {
            return redirect()->route('home');
        }
    }

    public function error403()
    {
        if(Auth::check())
        {
            if (Auth::user()->hasRole('admin'))
            {
                return redirect()->route('dashboard');
            }
            else if (Auth::user()->hasRole('user'))
            {
                return redirect()->route('home');
            }
        }else
        {
            return redirect()->route('home');
        }
    }
    public function error404()
    {
        if(Auth::check())
        {
            if (Auth::user()->hasRole('admin'))
            {
                return redirect()->route('dashboard');
            }
            else if (Auth::user()->hasRole('user'))
            {
                return redirect()->route('home');
            }
        }else
        {
            return redirect()->route('home');
        }
    }

    public function productByCategory($id)
    {
        $data = Product::where('category', '=', request()->id)->latest()->paginate(10);
        $category = Category::all();
        $selectCat = Category::findOrFail($id);
        return view('frontend.product_by_category', compact('data','category','selectCat'));
    }

    public function productDetailsView($id)
    {
        $data = Product::findOrFail($id);
        $category = Category::where('id', '=', $data->category)->first();
        $ip = $_SERVER['REMOTE_ADDR']; //build in function to get ip

        $check = ProductViewed::where([
            ['ip', '=', $ip],
            ['product_id', '=', $id]
        ])->first();

        if(empty($check)){

            ProductViewed::insert([
                'ip' => $ip,
                'product_id' => $id,
                'created_at' => Carbon::now(),
            ]);

        }
        return view('frontend.products.view', compact('data','category'));
    }

    public function superDeals()
    {
        $category = Category::all();
        $data = Product::where('oldPrice','!=','')->latest()->paginate(20);

        $ip = $_SERVER['REMOTE_ADDR'];
        $view = DB::table('product_vieweds')->where('ip','=',$ip)
            ->join('products','product_vieweds.product_id','=','products.id')
            ->select('products.*')
            ->latest()->paginate(6);

        return view('frontend.super_deals',compact('category','data','view'));
    }
    public function allProducts()
    {
        $category = Category::all();
        $data = Product::latest()->paginate(20);

        $ip = $_SERVER['REMOTE_ADDR'];
        $view = DB::table('product_vieweds')->where('ip','=',$ip)
            ->join('products','product_vieweds.product_id','=','products.id')
            ->select('products.*')
            ->latest()->paginate(6);

        return view('frontend.products',compact('category','data','view'));
    }

    public function searchProducts(Request $request)
    {
        if ($request->isMethod('post')) {
            $product = $request->search;
            $data = Product::where('name','LIKE','%'.$product.'%')->latest()->paginate(10);

            if (count($data) > 0){
                return response()->json(['data'=>1]);
            }else{
                return response()->json(['data'=>0]);
            }

        }else{
            return redirect()->route('home');
        }
    }

    public function searchResult($product)
    {
        $data = Product::where('name','LIKE','%'.$product.'%')->latest()->paginate(10);
        $category = Category::all();
        $ip = $_SERVER['REMOTE_ADDR'];
        $view = DB::table('product_vieweds')->where('ip','=',$ip)
            ->join('products','product_vieweds.product_id','=','products.id')
            ->select('products.*')
            ->latest()->paginate(6);

        return view('frontend.search_result',compact('category','data','view'));
    }
}
