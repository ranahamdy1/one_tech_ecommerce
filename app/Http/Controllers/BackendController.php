<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BackendController extends Controller
{
    public function dashboard()
    {
        return view('backend.index');
    }
    public function adminLogOut()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('home');
    }

    public function addCategory()
    {
        return view('backend.category.add');
    }

    public function addCategoryStore(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $check = Category::where('name','=',$request->name)->first();
            if (isset($check)){
                return response()->json(['data'=>0]);
            }else{
                $category = Category::insert([
                    'name' => $request->name,
                    'order' => $request->order,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['data'=>1]);
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }
}
