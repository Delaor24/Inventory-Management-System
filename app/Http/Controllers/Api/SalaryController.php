<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Salary;
class SalaryController extends Controller
{
    public function index($month){
        $salaries = Salary::with('employee')->where('salary_month',$month)->get();
        return response()->json($salaries);
    }
    public function salaryMonthList(){
         $salaries = Salary::select('salary_month')->groupBy('salary_month' )->get();
        return response()->json($salaries);
    }
    public function salaryPay(Request $request,$id){
    	$this->validate($request,[
    		'month'=>'required',
    	]);

    	$check = Salary::where('employee_id',$id)->where('salary_month',$request->month)->first();

    	if($check){
           return response()->json(['error'=>'Salary Already paid']);
    	}else{
    		$salary = new Salary();
	         $salary->employee_id = $id;
	         $salary->amount = $request->salary;
	         $salary->salary_month = $request->month;
	         $salary->salary_date = date('d/m/Y');
	         $salary->salary_year = date('Y');
	         $salary->save();
	         return response()->json(['success'=>'Salary Pay']);
    	}

         
    }
    public function salaryEdit($id){
        $salary = Salary::with('employee')->where('id',$id)->first();
        return response()->json($salary);
    }
    public function salaryUpdate(Request $request,$id){
        $this->validate($request,[
            'amount'=>'required',
            'salary_month'=>'required',
        ]);
        $salary = Salary::findOrfail($id);
       
            $salary->amount = $request->amount;
            $salary->salary_month = $request->salary_month;
            $salary->save();
            return response()->json(['succcess'=>'Update Salary']);
        
       
    }
    public function allSalary(){
        $salaries = Salary::with('employee')->get();
        return response()->json($salaries);
    }
    public function salaryDelete($id){
        $salary = Salary::findOrfail($id);
        $salary->delete();
        return response()->json(['success'=>'Salary Deleted']);
    }
}
