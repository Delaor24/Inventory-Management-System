<?php

namespace App\Http\Controllers\Api;

use App\Model\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::get();
        return response()->json($employees);
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
            'phone'=>'required|numeric|unique:employees',
            'email'=>'required|email|string|unique:employees',
            'nid'=>'required|numeric',
            'joiningDate'=>'required|date',
            'position'=>'required|string',
            'salary'=>'nullable|numeric',
        ]);

        $e = new Employee();
        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->image)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/employees/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            $e->image = $imgUrl;

        }
            $e->name = $request->name;
            $e->phone = $request->phone;
            $e->email = $request->email;
            $e->nid = $request->nid;
            $e->joiningDate = $request->joiningDate;
            $e->position = $request->position;
            $e->address = $request->address;
            $e->salary = $request->salary;
            $e->save();
            return response()->json(['success'=>'Add Employee']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emp = Employee::where('id',$id)->first();
        return response()->json($emp);
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
            'phone'=>'required|numeric|unique:employees,phone,'.$id,
            'email'=>'required|email|unique:employees,email,'.$id,
            'nid'=>'required|numeric',
            'joiningDate'=>'required|date',
            'position'=>'required|string',
            'salary'=>'nullable|numeric',
        ]);
        $e = Employee::where('id',$id)->first();
        if($request->newImage){
            $position = strpos($request->newImage,';');
            $sub = substr($request->newImage,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->newImage)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/employees/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            if($e->image){
                unlink($e->image);
            }
            $e->image = $imgUrl;
        }
        $e->name = $request->name;
        $e->phone = $request->phone;
        $e->email = $request->email;
        $e->nid = $request->nid;
        $e->joiningDate = $request->joiningDate;
        $e->position = $request->position;
        $e->address = $request->address;
        $e->salary = $request->salary;
        $e->status = $request->status;
        $e->save();

        return response()->json(['success'=>'Update Employee']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Employee::where('id',$id)->first();
        $photo = $emp->image;
        if($photo){
            unlink($photo);
            $emp->delete();
        }else{
            $emp->delete();
        }

    }
}
