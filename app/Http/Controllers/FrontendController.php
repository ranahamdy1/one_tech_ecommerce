<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

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

}
