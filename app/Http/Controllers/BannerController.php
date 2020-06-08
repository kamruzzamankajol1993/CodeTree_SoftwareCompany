<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{
    public function show(){

    	return view('admin.banner.add');
    }

    public function post(Request $request){

       $request->validate([

             
             'link'=>'required',
             'title'=>'required',
             'des'=>'required',
             
             
            
           
        ]);

    	$banner = new Banner();
    	$banner->title = $request->title;
    	$banner->link = $request->link;
    	$banner->des = $request->des;
    	
   	    $banner->save();

   	return redirect('/add/banner')->with('message','Saved succesfully');

    }


    public function manage(){

	$banners = Banner::paginate(10);
    	 return view('admin.banner.manage',['banners' => $banners]);
    }

    public function edit($id){
    	   $banner = Banner::find($id);

         return view('admin.banner.edit',['banner' => $banner]);
    }

     public function update(Request $request){
    	$banner = Banner::find($request->id);
        $banner->title = $request->title;
    	$banner->link = $request->link;
    	$banner->des = $request->des;
   	    $banner->save();
   	     return redirect('/manage/banner')->with('message','Updated Successfully');
    }

    public function delete($id){
        $banner = Banner::find($id);
        $banner->delete();

        return redirect('/manage/banner')->with('message','Deleted successfully');
    }
}
