<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BranchController extends Controller
{
    private $rediskeys = "";
    private $data;

    private $modelWithRedis;

    public function __construct()
    {
        $this->rediskeys = env("APP_NAME").'_branches';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parentBranch = $this->makeParentBranchOption();
        $allbranch = Branch::active()->with('parent')->get();
        $model = new Branch();
        return view("branch.index",compact('parentBranch','allbranch','model'));
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
        $request->validate([
            "branch_name" => "required|string"
        ]);
        $isgrand = 0;
        if ($request->has("parent_branch") && $request->parent_branch != null) {
            $parentbranch = Branch::find($request->parent_branch);
            $isgrand = $parentbranch->parent_branch != 0 ? 1:0;
        }
        $requestData = $request->all();
        $requestData['is_grand_child'] = $isgrand;
        //return dump($requestData);
        unset($requestData["_token"]);

        $create = Branch::insert($requestData);
        if ($create){
            $this->deleteCache();
            return back();
        }
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
        $model = Branch::whereId($id)->with('parent')->first();
        $parentBranch = $this->makeParentBranchOption($model->parent_branch);
        return view("branch.edit",compact('model','parentBranch'));
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
        $abc = Branch::find($id)->update($request->all());
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
        Branch::find($id)->delete();
        $this->deleteCache();
        return back();
    }

    private function makeParentBranchOption($selected = null){
        $parentBranch = new Branch();
        $parentBranch->setParam("where is_grand_child = 0",true);
        $branches = $parentBranch->getFromRedis();
        $option = null;

        foreach ($branches as $b){
            $select = $selected == $b->id ? "selected" : null;
            $option.= "<option $select value='{$b->id}'>{$b->branch_name}</option>";
        }
        return $option;


    }

    public function deleteCache(){
        $br = new Branch();
        $key = env("APP_NAME")."_".$br->getTable();
        Redis::del($key);
    }



}
