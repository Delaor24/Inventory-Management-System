<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Employee;
class Salary extends Model
{
    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
