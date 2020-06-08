<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;

class ShareController extends Controller
{
    public function show(){

    	return view('admin.share.add');
    }

    public function post(Request $request){

       $request->validate([

             'title'=>'required',
             'des'=>'required',
             'phone'=>'required',
             
            
           
        ]);

    	$share = new Share();
    	$share->title = $request->title;
    	$share->des = $request->des;
    	$share->phone = $request->phone;
   	    $share->save();

   	return redirect('/share/idea')->with('message','Saved succesfully');

    }


    public function manage(){

	$shares = Share::paginate(10);
    	 return view('admin.share.manage',['shares' => $shares]);
    }

    public function edit($id){
    	   $share = Share::find($id);

         return view('admin.share.edit',['share' => $share]);
    }

     public function update(Request $request){
    	$share = Share::find($request->id);
        $share->title = $request->title;
    	$share->des = $request->des;
    	$share->phone = $request->phone;
   	    $share->save();
   	     return redirect('/share/idea/manage')->with('message','Updated Successfully');
    }

    public function delete($id){
        $share = Share::find($id);
        $share->delete();

        return redirect('share/idea/manage')->with('message','Deleted successfully');
    }
}
