<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::all();
        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['product'] = new Product();
        $data['categories'] = Category::all();
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required',
            'category_id' => 'required',
            'stock_status' => 'required',
        ]);

        try {
            
            $input = $request->except(['category_id']);
            $input['user_id'] = auth()->user()->id;

            if($request->has('featured_image')){
                $fname = Str::random(10).'_'.$request->featured_image->getClientOriginalName();
                $request->featured_image->storeAs('public/product', $fname);
                $input['featured_image'] = 'product/'.$fname;
            }

            $input['slug'] = Helper::createSlug($request->name);
            $product = Product::updateOrCreate([
                'id' => Helper::decodeId($request->product_id)
            ], $input);

            ProductCategory::whereNotIn('category_id', $request->category_id)->where('product_id', $product->id)->delete();
            
            // save product categories
            foreach ($request->category_id as $value) {
                $pc = new ProductCategory();
                $pc->product_id = $product->id;
                $pc->category_id = $value;
                $pc->save();
            }

            return redirect()->route('product.edit', Helper::encodeId($product->id))->with('success', $request->has('product_id') ? 'Product Updated Successfully' : 'Product Created Successfully'); 

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data['product'] = Product::with(['categories', 'prices'])->find(Helper::decodeId($request->product));
        $data['categories'] = Category::all();
        return view('admin.product.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::where('id', Helper::decodeId($request->product))->delete();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    }

    public function storePrice(Request $request){
        
        $this->validate($request, [
            'product_id' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'required_with:discount',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        try {
            
            $input = $request->except('product_id');
            $input['product_id'] = Helper::decodeId($request->product_id);
            
            $product = ProductPrice::updateOrCreate([
                'id' => Helper::decodeId($request->price_id)
            ], $input);

            return redirect()->route('product.edit', [$request->product_id, '#price-tab'])->with('success', 'Price Added Successfully'); 

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    public function destroyPrice(Request $request)
    {
        ProductPrice::where('id', Helper::decodeId($request->price))->delete();
        return Redirect::to(URL::previous() . "#price-tab")->with('success', 'Price Deleted Successfully');
    }

    public function storeImage(Request $request){
        $this->validate($request, [
            'image' => 'required',
            'image.*' => 'required|mimes:jpg,jpeg,png,gif,bmp|max:2048',
        ],[
            'image.*.mimes' => 'Only jpg,jpeg,png,gif,bmp images are allowed',
            'image.*.max' => 'Maximum allowed size for an image is 2MB',
            'image.required' => 'Image field is required',
        ]);

        try {
            
            $product = Product::find(Helper::decodeId($request->product_id));
            Helper::upload($request->image, $product, 'product');

            return redirect()->route('product.edit', [$request->product_id, '#images-tab'])->with('success', 'Product Image Saved'); 

        } catch (\Exception $ex) {
            Helper::throwExeception($ex);
        }  
    }
}
