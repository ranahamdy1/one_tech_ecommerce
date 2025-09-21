<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.index');
    }

    public function userLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = $request->all();

            if(Auth::guard('web')->attempt(['email' => $check['email'], 'password' => $check['password']])){
                $user =User::where('email',$check['email'])->first();
                if (Auth::user()->hasRole('admin')) {
                    Auth::login($user);
                    return response()->json(['data'=> 1]);
                }else{
                    Auth::login($user);
                    return response()->json(['data'=> 2]);
                }
            }else{
                return response()->json(['data'=> 0]);
            }
        }else{
            return redirect()->route('home');
        }
    }
}
