<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Headline;
use App\Logo;
use App\Footer_v1;
use App\Address;
use App\Service_cat;
use App\Software;

use Image;

class HeadlineController extends Controller
{
    public function showform(){

    	return view('admin.news.add');
    }


    protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'news-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $headline = new Headline();
        $headline->title = $request->title;
        $headline->des = $request->des;
        $headline->image = $imageUrl;
       if($headline->save()){
            return redirect('/add/news/')->with('message','News Added Successfully');

        }
    }

     public function addnews(Request $request){
        $request->validate([

            
            'title'=>'nullable',
             'des'=>'nullable',
            'image'=>'required',
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

       return redirect('/add/news/')->with('error','There have an error !!');

    }

    public function showlist(){
    	$headlines = Headline::paginate(10);
        return view('admin.news.manage',['headlines' => $headlines]);
    }

    public function deletenews($id){
        $headline = Headline::find($id);
        $headline->delete();

        return redirect('/manage/news')->with('message','News deleted successfully');
    }

    public function editnews($id){

        $news = Headline::find($id);

         return view('admin.news.edit',['news' => $news]);
    }


    public function productInfoUpdate($headline, $request, $imageUrl){
        $headline->title = $request->title;
        $headline->des = $request->des;
        $headline->image = $imageUrl;
        $headline->save();
    }

    public function updatenews(Request $request){
        $productImage = $request->file('image');
        if($productImage){
            $headline = Headline::find($request->id);
            unlink($headline->image);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($headline, $request, $imageUrl);

            return redirect('/manage/news')->with('message','News Updated Successfully');

        } else {
            $headline = Headline::find($request->id);
            $headline->title = $request->title;
            $headline->des = $request->des;
           
            $headline->save();

            return redirect('/manage/news')->with('message','News Updated Successfully');
        }
    }


    //front-end section


    public function show_front_page(){

        $headlines=Headline::orderBy('id','DESC')
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
 $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();

       return view('front-end.news.news',['msoftwares'=>$msoftwares,'headlines'=>$headlines,'logos'=>$logos,'icons'=>$icons,'addresses'=>$addresses,'footers'=>$footers,'services'=>$services]);
    }
}
