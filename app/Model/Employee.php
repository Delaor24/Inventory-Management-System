<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name','phone','email','nid','joiningDate','position','salary','address','image'];
}
