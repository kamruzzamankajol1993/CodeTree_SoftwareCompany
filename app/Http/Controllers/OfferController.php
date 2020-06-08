<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Offerp;

use App\Pakagecategory;

class OfferController extends Controller
{
    public function show(){

    	return view('admin.offer.add');
    }

    

    public function post(Request $request){

       $request->validate([

             'icon'=>'required',
             'number'=>'required',
             'title'=>'required',
             'des'=>'required',
             
             
            
           
        ]);

    	$offer = new Offer();
    	$offer->title = $request->title;
    	$offer->icon = $request->icon;
    	$offer->number = $request->number;
    	$offer->des = $request->des;
    	
   	    $offer->save();

   	return redirect('/offer/add')->with('message','Saved succesfully');

    }
    


    public function manage(){

	$offers = Offer::paginate(10);
    	 return view('admin.offer.manage',['offers' => $offers]);
    }

    public function edit($id){
    	   $offer = Offer::find($id);

         return view('admin.offer.edit',['offer' => $offer]);
    }

     public function update(Request $request){
    	$offer = Offer::find($request->id);
        $offer->title = $request->title;
    	$offer->icon = $request->icon;
    	$offer->number = $request->number;
    	$offer->des = $request->des;
   	    $offer->save();
   	     return redirect('/offer/manage')->with('message','Updated Successfully');
    }

    public function delete($id){
        $offer = Offer::find($id);
        $offer->delete();

        return redirect('/offer/manage')->with('message','Deleted successfully');
    }


    

    
}
