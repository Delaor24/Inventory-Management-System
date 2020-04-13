<?php

namespace App\Http\Controllers\Api;

use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::get();
        return response()->json($suppliers);
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
            'name'=>'required|string|min:4',
            'phone'=>'required|numeric|unique:suppliers',
            'email'=>'required|email|string|unique:suppliers',
            'shopName'=>'nullable|string',
            'address'=>'required|string',
        ]);

        $supplier = new Supplier();
        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->image)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/employees/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            $supplier->image = $imgUrl;

        }
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->shopName = $request->shopName;
        $supplier->save();
        return response()->json(['success'=>'Add Supplier']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::where('id',$id)->first();
        return response()->json($supplier);
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
            'name'=>'required|string|min:4',
            'phone'=>'required|numeric|unique:suppliers,phone,'.$id,
            'email'=>'required|email|string|unique:suppliers,email,'.$id,
            'shopName'=>'nullable|string',
            'address'=>'required|string',
        ]);

        $supplier = Supplier::where('id',$id)->first();
        if($request->newImage){
            $position = strpos($request->newImage,';');
            $sub = substr($request->newImage,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->newImage)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/employees/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            if($supplier->image){
                unlink($supplier->image);
            }
            $supplier->image = $imgUrl;
        }
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->shopName = $request->shopName;
        $supplier->save();
        return response()->json(['success'=>'Update Supplier']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::where('id',$id)->first();
        $photo = $supplier->image;
        if($photo){
            unlink($photo);
            $supplier->delete();
        }else{
            $supplier->delete();
        }
    }
}
