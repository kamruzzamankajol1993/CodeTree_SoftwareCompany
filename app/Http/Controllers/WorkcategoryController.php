<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workcategory;

class WorkcategoryController extends Controller
{
    Public function showform(){
    	return view('admin.work.category.add');
    }

    public function saveform(Request $request){
    	$workcategory = new Workcategory();
   	$workcategory->title = $request->title;
   	$workcategory->status = $request->status;
   	$workcategory->save();

   	return redirect('/work/category/add')->with('message','Category saved succesfully');
    }
   public function showcategorylist(){
        $workcategories = Workcategory::all();
    	return view('admin.work.category.manage',['workcategories' => $workcategories]);
    }

    public function unpublishedcategory($id){
        $workcategory = Workcategory::find($id);
        $workcategory->status = 0;
        $workcategory->save();

        return redirect('/work/category/manage');
    }

    public function publishedcategory($id){
        $workcategory = Workcategory::find($id);
        $workcategory->status = 1;
        $workcategory->save();

        return redirect('/work/category/manage');
    }

    public function editcategory($id){
        $workcategory = Workcategory::find($id);
        return view('admin.work.category.edit',['workcategory'=>$workcategory]);
    }

     public function updatecategory(Request $request){
        $workcategory = Workcategory::find($request->id);
        $workcategory->title = $request->title;
        $workcategory->status = $request->status;
        $workcategory->save();

        return redirect('/work/category/manage')->with('message','Category Updated Successfully');
    }

    public function deletecategory($id){
        $workcategory = Workcategory::find($id);
        $workcategory->delete();

        return redirect('/work/category/manage')->with('message','Category deleted successfully');
    }
}
