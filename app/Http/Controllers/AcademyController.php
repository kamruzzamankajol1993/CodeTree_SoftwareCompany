<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Academy;
use App\Logo;
use App\Address;
use App\Footer_v1;
use App\Service_cat;
use App\Software;

use Image;

class AcademyController extends Controller
{
     public function showform(){

    	return view('admin.academy.add');
    }


    protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'news-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(1601,801)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $headline = new Academy();
        $headline->title = $request->title;
        $headline->des = $request->des;
        $headline->status = $request->status;
        $headline->image = $imageUrl;
       if($headline->save()){
            return redirect('/add/academy/')->with('message','Added Successfully');

        }
    }

     public function addnews(Request $request){
        $request->validate([

            
            'title'=>'nullable',
             'des'=>'nullable',
            'image'=>'required',
             'status'=>'required',
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

       return redirect('/add/academy/')->with('error','There have an error !!');

    }

    public function showlist(){
    	$headlines = Academy::paginate(10);
        return view('admin.academy.manage',['headlines' => $headlines]);
    }

    public function deletenews($id){
        $headline = Academy::find($id);
        $headline->delete();

        return redirect('/manage/academy')->with('message','News deleted successfully');
    }

    public function editnews($id){

        $news = Academy::find($id);

         return view('admin.academy.edit',['news' => $news]);
    }


    public function productInfoUpdate($headline, $request, $imageUrl){
        $headline->title = $request->title;
        $headline->des = $request->des;
        $headline->status = $request->status;
        $headline->image = $imageUrl;
        $headline->save();
    }

    public function updatenews(Request $request){
        $productImage = $request->file('image');
        if($productImage){
            $headline = Academy::find($request->id);
            unlink($headline->image);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($headline, $request, $imageUrl);

            return redirect('/manage/academy')->with('message','Updated Successfully');

        } else {
            $headline = Academy::find($request->id);
            $headline->title = $request->title;
            $headline->des = $request->des;
           $headline->status = $request->status;
            $headline->save();

            return redirect('/manage/academy')->with('message','Updated Successfully');
        }
    }

    public function unpublish($id){
        $workcategory = Academy::find($id);
        $workcategory->status = 0;
        $workcategory->save();

        return redirect('/manage/academy');
    }

    public function publish($id){
        $workcategory = Academy::find($id);
        $workcategory->status = 1;
        $workcategory->save();

        return redirect('/manage/academy');
    }


    public function show(){


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

        $academylists=Academy::orderBy('id','DESC')
                     ->get();


       return view('front-end.academy.academy',['msoftwares'=>$msoftwares,'logos'=>$logos,'icons'=>$icons,'addresses'=>$addresses,'footers'=>$footers,'services'=>$services,'academylists'=>$academylists]);
    }

}
