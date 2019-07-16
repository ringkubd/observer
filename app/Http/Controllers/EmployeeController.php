<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $model = new Employee();
        $model->setParam();
        $data = $model->all();
        $branch = $this->makeBranchOption();
        return view("employee.index",compact('model','branch','data'));
    }

    private function makeBranchOption($selected = null){
        $parentBranch = new Employee();
        $parentBranch->setParam("where isdelete = 0",'branches');
        $branches = $parentBranch->getFromRedis();
        $option = null;
        foreach ($branches as $b){
            $select = $selected == $b->id ? "selected" : null;
            $option.= "<option $select value='{$b->id}'>{$b->branch_name}</option>";
        }
        return $option;
    }

    /**
     *
     */

    public function deleteCache(){
        $br = new Client();
        $key = env("APP_NAME")."_".$br->getTable();
        Redis::del($key);
    }
}
