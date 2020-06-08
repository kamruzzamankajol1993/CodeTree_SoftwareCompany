<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Need;

class NeedController extends Controller
{
    public function show_service_offer(){
        return view('admin.pakage.category.add');
    }


    public function post_service_offer(Request $request){

       $request->validate([

             'name'=>'required',
             'offer_price'=>'required',
             'title'=>'required',
             'main_price'=>'required',
             
             
            
           
        ]);

        $need = new Need();
        $need->title = $request->title;
        $need->name = $request->name;
        $need->main_price = $request->main_price;
        $need->offer_price = $request->offer_price;
        
        $need->save();

    return redirect('/service')->with('message','Saved succesfully');

    }

    public function managep(){

    $pakages =Need::paginate(10);
         return view('admin.pakage.category.manage',['pakages' => $pakages]);
    }

    public function editp($id){
           $pakage =Need::find($id);

         return view('admin.pakage.category.edit',['pakage' => $pakage]);
    }

     public function updatep(Request $request){
        $pakage =Need::find($request->id);
        $pakage->title = $request->title;
        $pakage->name = $request->name;
        $pakage->main_price = $request->main_price;
        $pakage->offer_price = $request->offer_price;
        $pakage->save();
         return redirect('/pakage/category/manage')->with('message','Updated Successfully');
    }

    public function deletep($id){
        $pakage =Need::find($id);
        $pakage->delete();

        return redirect('/pakage/category/manage')->with('message','Deleted successfully');
    }
}
