<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

    //categories
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

    public function category()
    {
        $data = Category::latest()->paginate(10);
        return view('backend.category.index',compact('data'));
    }

    public function editCategory($id)
    {
        $data = Category::findOrFail($id);
        return view('backend.category.edit',compact('data'));
    }

    public function updateCategory(Request $request)
    {
        $data = Category::where('id','=',$request->id)->update([
            'name'=>strip_tags($request->name),
            'order'=>strip_tags($request->order)
        ]);
        return response()->json(['data'=>$data]);
    }

    public function deleteCategory(Request $request)
    {
        $data = Category::where('id' ,'=',$request->id)->delete();
        return response()->json(['data'=>$data]);
    }

    //products
    public function addProducts()
    {
        $category = Category::all();
        return view('backend.products.add',compact('category'));
    }
    public function addProductsStore(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
                'category' => 'required|string|max:255',
                'productName' => 'required|string|max:255',
                'oldPrice' => 'required|numeric',
                'newPrice' => 'required|numeric',
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
                'des' => 'nullable|string',
            ]);

            // images
            $image = $request->file('image');
            $gen = hexdec(uniqid());
            $ext = strtolower($image->getClientOriginalExtension());
            $fileName = $gen . '.' . $ext;
            $location = 'products/';
            $source = $location . $fileName;

            $image->move(public_path($location), $fileName);

            // insert data
            $data = Product::insert([
                'category' => $request->category,
                'name' => strip_tags($request->productName),
                'oldPrice' => strip_tags($request->oldPrice),
                'newPrice' => strip_tags($request->newPrice),
                'image' => $source,
                'des' => strip_tags($request->des),
                'created_at' => Carbon::now(),
            ]);

            return response()->json(['data' => $data]);
        }
    }


    public function product()
    {
        $product = Product::latest()->paginate(10);
        return view('backend.products.index',compact('product'));
    }

    public function editProduct($id)
    {
        $data = Product::findOrFail($id);
        $category = Category::all();
        return view('backend.products.edit',compact('data','category'));
    }

    public function updateProduct(Request $request)
    {
        $product = Product::where('id', '=', $request->id)->first();
        if (!$product) {
            return response()->json(['data' => 0, 'message' => 'Product not found']);
        }
        $source = $product->image; // افتراضياً خلي الصورة القديمة موجودة

        if ($request->hasFile('image')) {
            // امسح الصورة القديمة لو موجودة
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // صور جديدة
            $image = $request->file('image');
            $gen = hexdec(uniqid());
            $ext = strtolower($image->getClientOriginalExtension());
            $fileName = $gen . '.' . $ext;
            $location = 'products/';
            $source = $location . $fileName;

            $image->move(public_path($location), $fileName);
        }

        $product->name = strip_tags($request->name);
        $product->category = strip_tags($request->category);
        $product->oldPrice = strip_tags($request->oldPrice);
        $product->newPrice = strip_tags($request->newPrice);
        $product->image = $source;

        $saved = $product->save();

        return response()->json(['data' => $saved ? 1 : 0]);
    }

    public function deleteProduct(Request $request)
    {
        $data = Product::where('id' ,'=',$request->id)->delete();
        return response()->json(['data'=>$data]);
    }
}
