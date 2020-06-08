<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Need;
use App\Service;
use App\Service_detail;

class ServiceDetailController extends Controller
{
    public function show(){
      
      $offers = Need::all();

      return view('admin.pakage.detail.add',['offers'=>$offers]);

    }


    public function post(Request $request){

     	
         $request->validate([

             'service_name'=>'required',
             'category_name'=>'required',
             'status'=>'required',
            ]);

    	$number=count($request->service_name);

        if($number >0){
            for($i=0;$i<$number;$i++){
                $data=array([
                    'service_name'=>$request->service_name[$i],
                    'category_name'=>$request->category_name,
                    'status'=>$request->status
                ]);
                
               Service::insert($data);
            }

        }
    	


   	return redirect('/offerdetail')->with('message','Service saved succesfully');
    }

    public function manage(){

    	$details = Service::paginate(10);
    	 return view('admin.pakage.detail.manage',['details' => $details]);
    }

    public function edit($id){

    	$detail = Service::find($id);
        $offers = Need::all();
         return view('admin.pakage.detail.edit',['detail' => $detail,'offers'=>$offers]);
    }

    public function update(Request $request){
    	$detail = Service::find($request->id);
      $detail->service_name = $request->service_name;
    	$detail->category_name = $request->category_name;
    	$detail->status = $request->status;
    	$detail->save();
   	     return redirect('/offerdetail/manage')->with('message','Updated Successfully');
    }

    public function delete($id){
        $detail = Service::find($id);
        $detail->delete();

        return redirect('/offerdetail/manage')->with('message','Deleted successfully');
    }
}
