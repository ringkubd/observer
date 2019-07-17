<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(){
        $data = User::with('branch')->get();
        $model = new User();
        $branch = $this->makeBranchOption();
        return view("employee.index",compact('model','branch','data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("branch.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqData = $request->all();
        $branch = $reqData["branch_id"];
        unset($reqData["branch_id"]);
        $reqData["password"] =  Hash::make($reqData["password"]);
        $user =  User::create($reqData);
        $user->branch()->attach($branch);
        $user->sendEmailVerificationNotification();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::whereId($id)->with('branch')->first();
        $parentBranch = $this->makeParentBranchOption();
        return view("employee.edit",compact('model','parentBranch'));
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
        $abc = User::find($id)->update($request->all());
        $this->deleteCache();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        $this->deleteCache();
        return back();
    }

    private function makeBranchOption($selected = null){
        $branches =  Branch::where("isdelete",0)->get();
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
        $br = new Employee();
        $key = env("APP_NAME")."_".$br->getTable();
        //Redis::del($key);
    }
}
