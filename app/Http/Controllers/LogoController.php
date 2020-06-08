<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logo;

use Image;

class LogoController extends Controller
{
    
 public function showform(){

    	return view('admin.Logo.add');
    }


    protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'logo-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(2400,600)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $logo = new Logo();
        $logo->status = $request->status;
        $logo->image = $imageUrl;
       if($logo->save()){
            return redirect('/add/logo/')->with('message','Added Successfully');

        }
    }

     public function addnews(Request $request){
        $request->validate([

            
         'image'=>'required',
         'status'=>'required',
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

       return redirect('/add/logo/')->with('error','There have an error !!');

    }

    public function showlist(){
    	$logos = Logo::paginate(10);
        return view('admin.Logo.manage',['logos' => $logos]);
    }

    public function deletenews($id){
        $logo = Logo::find($id);
        $logo->delete();

        return redirect('/manage/logo')->with('message','Deleted successfully');
    }

    public function editnews($id){

        $logo = Logo::find($id);

         return view('admin.Logo.edit',['logo' => $logo]);
    }


    public function productInfoUpdate($logo, $request, $imageUrl){
        $logo->status = $request->status;
        $logo->image = $imageUrl;
        $logo->save();
    }

    public function updatenews(Request $request){
        $productImage = $request->file('image');
        if($productImage){
            $logo = Logo::find($request->id);
            unlink($logo->image);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($logo, $request, $imageUrl);

            return redirect('/manage/logo')->with('message','Updated Successfully');

        } else {
            $logo = Logo::find($request->id);
            $logo->status = $request->status;
             $logo->save();

            return redirect('/manage/logo')->with('message','Updated Successfully');
        }
    }
}
