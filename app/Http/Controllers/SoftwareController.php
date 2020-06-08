<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Software;
use App\Softwaremodule;
use App\Logo;
use App\Address;
use App\Footer_v1;
use App\Service_cat;

use Image;

class SoftwareController extends Controller
{
     public function showform(){

    	return view('admin.software.add');
    }

    public function saveform(Request $request){

       $request->validate([

             'name'=>'required',
             'des'=>'nullable',
             'status'=>'required',
             
            
           
        ]);

    	$software = new Software();
    	$software->name = $request->name;
        $software->des = $request->des;
    	$software->status = $request->status;
   	    $software->save();

   	return redirect('/software/add')->with('message','Saved succesfully');

    }

     public function showsoftwarelist(){

	$softwares = Software::paginate(10);
    	 return view('admin.software.manage',['softwares'=>$softwares]);
    }

    public function editsoftware($id){
    	   $software = Software::find($id);

         return view('admin.software.edit',['software' => $software]);
    }

     public function updatesoftware(Request $request){
    	$software = Software::find($request->id);
        $software->name = $request->name;
        $software->des = $request->des;
    	$software->status = $request->status;
   	    $software->save();
   	     return redirect('/software/manage')->with('message','Updated Successfully');
    }

    public function deletesoftware($id){
        $software = Software::find($id);
        $software->delete();

        return redirect('/software/manage')->with('message','Deleted successfully');
    }

    public function unpublishedsoftware($id){
        $software = Software::find($id);
        $software->status = 0;
        $software->save();

        return redirect('/software/manage');
    }

    public function publishedsoftware($id){
        $software = Software::find($id);
        $software->status = 1;
        $software->save();

        return redirect('/software/manage');
    }

    //front-end work

    public function showdetail($name){


        $details=Softwaremodule::where('soft_id',$name)
                                ->orderBy('id','ASC')
                                ->get();
        $softwarename=Software::where('name',$name)->value('name');

        $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();
        $logos=Logo::where('status',1) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();
        $icons=Logo::where('status',0) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();
        $addresses=Address::orderBy('id','DESC')
                     ->take(1)
                     ->get();
        $footers=Footer_v1::orderBy('id','DESC')
                     ->take(1)
                     ->get();
        $services=Service_cat::orderBy('id','ASC')
                     ->get();


       return view('front-end.software.software',['softwarename'=>$softwarename,'details'=>$details,'msoftwares'=>$msoftwares,'logos'=>$logos,'icons'=>$icons,'addresses'=>$addresses,'footers'=>$footers,'services'=>$services]);
    }
}
