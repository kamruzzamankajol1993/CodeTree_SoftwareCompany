<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Footer_v1;

class FooterController extends Controller
{
    public function show(){

    	return view('admin.footer.footer-bottom.add');
    }

    public function post(Request $request){

       $request->validate([

             'name'=>'required',
             'office_link'=>'required',
             'fb_link'=>'required',
             'ins_link'=>'nullable',
             'linkin_link'=>'nullable',
             'you_link'=>'nullable',
             'tc'=>'nullable',
             'location'=>'required',
             
            
           
        ]);

    	$footer = new Footer_v1();
    	$footer->name = $request->name;
    	$footer->office_link = $request->office_link;
    	$footer->fb_link = $request->fb_link;
    	$footer->ins_link = $request->ins_link;
    	$footer->linkin_link = $request->linkin_link;
    	$footer->tc = $request->tc;
        $footer->you_link = $request->you_link;
    	$footer->location = $request->location;
   	    $footer->save();

   	return redirect('/add/footer')->with('message','Saved succesfully');

    }


    public function manage(){

	$footers = Footer_v1::paginate(10);
    	 return view('admin.footer.footer-bottom.manage',['footers' => $footers]);
    }

    public function edit($id){
    	   $footer = Footer_v1::find($id);

         return view('admin.footer.footer-bottom.edit',['footer' => $footer]);
    }

     public function update(Request $request){
    	$footer = Footer_v1::find($request->id);
        $footer->name = $request->name;
    	$footer->office_link = $request->office_link;
    	$footer->fb_link = $request->fb_link;
    	$footer->ins_link = $request->ins_link;
    	$footer->linkin_link = $request->linkin_link;
    	$footer->tc = $request->tc;
        $footer->you_link = $request->you_link;
    	$footer->location = $request->location;
   	    $footer->save();
   	     return redirect('/manage/footer')->with('message','Updated Successfully');
    }

    public function delete($id){
        $footer = Footer_v1::find($id);
        $footer->delete();

        return redirect('/manage/footer')->with('message','Deleted successfully');
    }
}
