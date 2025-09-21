<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function newAccount(Request $request)
    {
            if ($request->isMethod('post')) {
                $check = User::where('email', '=', $request->email)->first();
                if(isset($check)){
                    return response()->json(['data'=>0]);
                }else{
                    $user = new User();
                    $user->name = strip_tags($request->name);
                    $user->email = strip_tags($request->email);
                    $user->password = Hash::make($request->password);
                    $user->created_at = Carbon::now();
                    $user->save();

                    $user->assignRole('user');
                    Auth::login($user);

                    return response()->json(['data'=>1]);
                }
            }else{
                return redirect()->route('home');
            }
    }
}
