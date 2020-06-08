<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Count;

class CountController extends Controller
{
    public function show(){

    	return view('admin.count.add');
    }

    public function post(Request $request){

       $request->validate([

             'title'=>'required',
             'number'=>'required',
             
      ]);

    	$count = new Count();
    	$count->title = $request->title;
    	$count->number = $request->number;
    	$count->save();

   	return redirect('/count/add')->with('message','Saved succesfully');

    }


    public function manage(){

	$counts = Count::paginate(10);
    	 return view('admin.count.manage',['counts' => $counts]);
    }

    public function edit($id){
    	   $count = Count::find($id);

         return view('admin.count.edit',['count' => $count]);
    }

     public function update(Request $request){
    	$count = Count::find($request->id);
        $count->title = $request->title;
    	$count->number = $request->number;
    	$count->save();
   	     return redirect('/count/manage')->with('message','Updated Successfully');
    }

    public function delete($id){
        $count = Count::find($id);
        $count->delete();

        return redirect('/count/manage')->with('message','Deleted successfully');
    }
}
