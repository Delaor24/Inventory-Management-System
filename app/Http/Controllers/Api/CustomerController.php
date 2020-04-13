<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Model\Customer;
class CustomerController extends Controller
{
   
    public function index()
    {
        $customers = Customer::get();
        return response()->json($customers);
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
            'phone'=>'required|numeric|unique:customers',
            'email'=>'nullable|email|string|unique:customers',
            'address'=>'required',
        ]);

        $c = new Customer();
        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->image)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/customers/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            $c->image = $imgUrl;

        }
            $c->name = $request->name;
            $c->phone = $request->phone;
            $c->email = $request->email;
            $c->address = $request->address;
       
            $c->save();
            return response()->json(['success'=>'Add Customer']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where('id',$id)->first();
        return response()->json($customer);
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
            'phone'=>'required|numeric|unique:customers,phone,'.$id,
            'email'=>'nullable|email|unique:customers,email,'.$id,
            'address'=>'required',
           
        ]);
        $c = Customer::where('id',$id)->first();
        if($request->newImage){
            $position = strpos($request->newImage,';');
            $sub = substr($request->newImage,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->newImage)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/customers/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            if($c->image){
                unlink($c->image);
            }
            $c->image = $imgUrl;
        }
        $c->name = $request->name;
        $c->phone = $request->phone;
        $c->email = $request->email;
        $c->address = $request->address;
        $c->save();

        return response()->json(['success'=>'Update Customer']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('id',$id)->first();
        $photo = $customer->image;
        if($photo){
            unlink($photo);
            $customer->delete();
        }else{
            $customer->delete();
        }

    }
}
