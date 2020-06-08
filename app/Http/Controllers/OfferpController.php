<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offerp;

class OfferpController extends Controller
{
    public function showp(){

        return view('admin.pakage.category.add');
    }

    public function postp(Request $request){

       $request->validate([

             'name'=>'required',
             'offer_price'=>'required',
             'title'=>'required',
             'main_price'=>'required',
             
             
            
           
        ]);

        $pakage = new Offerp();
        $pakage->title = $request->title;
        $pakage->name = $request->name;
        $pakage->main_price = $request->main_price;
        $pakage->offer_price = $request->offer_price;
        
        $pakage->save();

    return redirect('/pakage/category/add')->with('message','Saved succesfully');

    }


    public function managep(){

    $pakages = Offerp::paginate(10);
         return view('admin.pakage.category.manage',['pakages' => $pakages]);
    }

    public function editp($id){
           $pakage = Offerp::find($id);

         return view('admin.pakage.category.edit',['pakage' => $pakage]);
    }

     public function updatep(Request $request){
        $pakage = Offerp::find($request->id);
        $pakage->title = $request->title;
        $pakage->name = $request->name;
        $pakage->main_price = $request->main_price;
        $pakage->offer_price = $request->offer_price;
        $pakage->save();
         return redirect('/pakage/category/manage')->with('message','Updated Successfully');
    }

    public function deletep($id){
        $pakage = Offerp::find($id);
        $pakage->delete();

        return redirect('/pakage/category/manage')->with('message','Deleted successfully');
    }
}
