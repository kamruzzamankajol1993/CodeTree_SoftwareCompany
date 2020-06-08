<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
    public function show(){

    	return view('admin.footer.office_address.add');
    }

    public function post(Request $request){

       $request->validate([

             'email'=>'required',
             'phone'=>'required',
             'title'=>'required',
             'des'=>'nullable',
             'add'=>'nullable',
             'loaction'=>'nullable',
             
            
           
        ]);

    	$address = new Address();
    	$address->title = $request->title;
    	$address->email = $request->email;
    	$address->phone = $request->phone;
    	$address->add = $request->add;
    	$address->des = $request->des;
    	$address->loaction = $request->loaction;
   	    $address->save();

   	return redirect('/add/address')->with('message','Saved succesfully');

    }


    public function manage(){

	$addresses = Address::paginate(10);
    	 return view('admin.footer.office_address.manage',['addresses' => $addresses]);
    }

    public function edit($id){
    	   $address = Address::find($id);

         return view('admin.footer.office_address.edit',['address' => $address]);
    }

     public function update(Request $request){
    	$address = Address::find($request->id);
        $address->title = $request->title;
    	$address->email = $request->email;
    	$address->phone = $request->phone;
    	$address->add = $request->add;
    	$address->des = $request->des;
    	$address->loaction = $request->loaction;
   	    $address->save();
   	     return redirect('/manage/address')->with('message','Updated Successfully');
    }

    public function delete($id){
        $address = Address::find($id);
        $address->delete();

        return redirect('/manage/address')->with('message','Deleted successfully');
    }
}
