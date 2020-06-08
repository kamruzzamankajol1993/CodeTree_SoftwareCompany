<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feature;

class FeatureController extends Controller
{
     public function show(){

    	return view('admin.feature.add');
    }

    public function post(Request $request){

       $request->validate([

             'title'=>'nullable',
             'icon'=>'required',
             'wtitle'=>'required',
             'des'=>'required',
             
            
           
        ]);

    	$feature = new Feature();
    	$feature->title = $request->title;
    	$feature->icon = $request->icon;
    	$feature->wtitle = $request->wtitle;
    	$feature->des = $request->des;
   	    $feature->save();

   	return redirect('/feature/add')->with('message','Saved succesfully');

    }


    public function manage(){

	$features = Feature::paginate(10);
    	 return view('admin.feature.manage',['features' => $features]);
    }

    public function edit($id){
    	   $feature = Feature::find($id);

         return view('admin.feature.edit',['feature' => $feature]);
    }

     public function update(Request $request){
    	$feature = Feature::find($request->id);
        $feature->title = $request->title;
    	$feature->icon = $request->icon;
    	$feature->wtitle = $request->wtitle;
    	$feature->des = $request->des;
   	    $feature->save();
   	     return redirect('/feature/manage')->with('message','Updated Successfully');
    }

    public function delete($id){
        $feature = Feature::find($id);
        $feature->delete();

        return redirect('/feature/manage')->with('message','Deleted successfully');
    }
}
