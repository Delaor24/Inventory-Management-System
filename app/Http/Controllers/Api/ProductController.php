<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Model\Product;
class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category','supplier')->get();
        return response()->json($products);
    }
    public function allProducts(){
        $products = Product::latest()->paginate(2);
        return response()->json($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'p_name'=>'required|string',
            'p_code'=>'nullable|unique:products',
            'category_id'=>'required',
            'buying_price'=>'nullable|numeric',
            'selling_price'=>'required|numeric',
            'p_quantity'=>'required|numeric',

        ]);

        $p = new Product();
        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->image)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/products/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            $p->image = $imgUrl;

        }
            $p->p_name = $request->p_name;
            $p->p_code = $request->p_code;
            $p->category_id = $request->category_id;
            $p->supplier_id = $request->supplier_id;
            $p->buying_date = $request->buying_date;
            $p->buying_price = $request->buying_price;
            $p->selling_price = $request->selling_price;
            $p->root = $request->root;
            $p->p_quantity = $request->p_quantity;
            $p->save();
            return response()->json(['success'=>'Add Product']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id',$id)->first();
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'p_name'=>'required|string',
            'p_code'=>'nullable|unique:products,p_code,'.$id,
            'category_id'=>'required',
            'buying_price'=>'nullable|numeric',
            'selling_price'=>'required|numeric',


        ]);

        $p = Product::where('id',$id)->first();
        if($request->newImage){
            $position = strpos($request->newImage,';');
            $sub = substr($request->newImage,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->newImage)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/products/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            if($p->image){
                unlink($p->image);
            }
            $p->image = $imgUrl;

        }
            $p->p_name = $request->p_name;
            $p->p_code = $request->p_code;
            $p->category_id = $request->category_id;
            $p->supplier_id = $request->supplier_id;
            $p->buying_date = $request->buying_date;
            $p->buying_price = $request->buying_price;
            $p->selling_price = $request->selling_price;
            $p->root = $request->root;
            $p->p_quantity = $request->p_quantity;
            $p->save();
            return response()->json(['success'=>'Update Product']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id',$id)->first();
        $photo = $product->image;
        if($photo){
            unlink($photo);
            $product->delete();
        }else{
            $product->delete();
        }

    }
}
