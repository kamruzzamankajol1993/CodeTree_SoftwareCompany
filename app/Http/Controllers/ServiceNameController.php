<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service_name;
use App\Service_cat;
use App\Service_subcat;
use App\Logo;
use App\Footer_v1;
use App\Address;
use App\Software;


use DB;
use Image;


class ServiceNameController extends Controller
{
    public function showdet(){
        $categories = Service_cat::all();
        return view('admin.service.service_detail.add',['categories' => $categories]);
    }

//to show subcategory filed in service page
    public function findProductName(Request $request){

        $data=Service_subcat::select('sub_name','id')->where('cat_id',$request->id)->get();
        return response()->json($data);
	}

//to show subcategory filed in service page
 protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'service-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $headline = new Service_name();
        $headline->cat_id = $request->cat_id;
        $headline->sub_id = $request->sub_id;
        $headline->image = $imageUrl;
       if($headline->save()){
            return redirect('add/servicedet')->with('message','Added Successfully');

        }
    }

	public function adddet(Request $request){

 $request->validate([

            
            'cat_id'=>'required',
             'sub_id'=>'required',
            'image'=>'required',
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

       return redirect('add/servicedet')->with('error','There have an error !!');
		
	}


	public function showdetlist(){

    	//$details = Service_name::paginate(10);
        $details = DB::table('service_subcats')
          ->join('service_cats', 'service_cats.id', '=', 'service_subcats.cat_id')
          ->join('service_names','service_names.sub_id','=','service_subcats.id')
          ->select('service_subcats.sub_name','service_names.*','service_cats.name')
          ->paginate(10);      
    	 return view('admin.service.service_detail.manage',['details' => $details]);
    }

    public function editdet($id){

    	$detail = Service_name::find($id);
    	//$subs = Service_name::where('sub_id',$id)
                          //->get();
        $categories = Service_cat::all();
         return view('admin.service.service_detail.edit',['detail' => $detail,'categories'=>$categories]);
    }

    public function updatedet(Request $request){
    	$detail = Service_name::find($request->id);
      $detail->service = $request->service;
    	$detail->cat_id = $request->cat_id;
    	$detail->sub_id = $request->sub_id;
    	$detail->save();
   	     return redirect('/manage/servicedet')->with('message','Updated Successfully');
    }

    public function deletedet($id){
        $detail = Service_name::find($id);
        $detail->delete();

        return redirect('/manage/servicedet')->with('message','Deleted successfully');
    }


public function categorydetails($id){


 $categorydetails= Service_name::where('cat_id',$id)->get();
 $titles=Service_cat::where('id',$id)->get();
 $titlesubs=Service_subcat::where('cat_id',$id)->get();
 $cats=DB::table('service_cats')->get();
 //$subcats=DB::table('service_names')->get();

  $subcats = DB::table('service_names')
          ->join('service_subcats', 'service_subcats.id', '=', 'service_names.sub_id')
          
          ->select('service_subcats.sub_name','service_names.*')
          ->get();

 $logos=Logo::where('status',1)->orderBy('id','DESC')->take(1)->get();

$icons=Logo::where('status',0)->orderBy('id','DESC')->take(1)->get();
$addresses=Address::orderBy('id','DESC')->take(1)->get();
$footers=Footer_v1::orderBy('id','DESC')->take(1)->get();
$services=Service_cat::orderBy('id','ASC')->get();

 $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();
 return view('front-end.service.service_detail',['msoftwares'=>$msoftwares,'categorydetails' => $categorydetails,'cats'=>$cats,'subcats'=>$subcats,'logos'=>$logos,'icons'=>$icons,'addresses'=>$addresses,'footers'=>$footers,'services'=>$services,'titles'=>$titles,'titlesubs'=>$titlesubs]);


}
}
