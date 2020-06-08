<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workcategory;
use App\Work1;
use App\Portfolio;
use App\Portfolio_image;
use App\Address;
use App\Footer_v1;
use App\Logo;
use App\Service_cat;

use Image;
use DB;

class WorkController extends Controller
{
   public function show(){
    	$categories = Workcategory::all();
    	return view('admin.work.work_detail.add',[
            'categories' => $categories
            
        ]);
    }


     protected function imageUpload($request){
        $productImage = $request->file('logo');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'work-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(500,331)->save($imageUrl);

        return $imageUrl;
    }

    protected function mainimageUpload($request){
      
        if($request->file('image')){
            foreach($request->file('image') as $mainimageUrl)
            {
              
            $imageName = $mainimageUrl->getClientOriginalName();
            $mainimageUrl->move(public_path().'/work-image/', $imageName);  
            $data[]=$imageName;
         }
            return $data;
        }
        
    }

     protected function saveProductInfo($request, $imageUrl,$data){
        $work = new Portfolio();
        $work->cat_id = $request->cat_id;
        $work->link = $request->link;
        if($request->link == Null){
            $work->image=1;
        }
        $work->name=$request->name;
        $work->logo = $imageUrl;
        $work->save();

       
       if(isset($data)){
        for($i=0;$i<count($data); $i++)
        {
             $data1=array([
                    'port_id'=>$work->id,
                    'cat_id'=>$work->cat_id,
                    'image'=>$data[$i]
                    
                ]);
             Portfolio_image::insert($data1);
        }
    }

        
            return redirect('work/detail/add')->with('message','Added Successfully');

        }
    

     public function post(Request $request){
        $request->validate([

            
            'cat_id'=>'required',
            'name'=>'required',
             'link'=>'nullable',
            'image'=>'nullable',
            'logo'=>'required'
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
         $mainimageUrl = $this->mainimageUpload($request);
        $this->saveProductInfo($request, $imageUrl,$mainimageUrl);

       return redirect('work/detail/add')->with('error','There have an error !!');

    }
    //show image list
    public function manage(){
    	//$works = Work1::paginate(10);
        $works = DB::table('portfolios')
          ->join('workcategories', 'workcategories.id', '=', 'portfolios.cat_id')
          //->join('portfolio_images', 'portfolio_images.port_id', '=', 'portfolios.id')
           ->select('workcategories.*','portfolios.*')
                    ->paginate(8);
        $images = DB::table('portfolio_images')
                   ->get();
        return view('admin.work.work_detail.manage',['works' => $works,'images'=>$images]);
    }
    //show image list

    public function delete($id){
        $work = Portfolio::find($id);
        $work->delete();

        $port = Portfolio_image::where('port_id',$id);
        $port->delete();
        return redirect('work/detail/manage')->with('message','Deleted successfully');
    }

    public function edit($id){
         $categories = Workcategory::all();
         $port = Portfolio::find($id);
         $port_images = Portfolio_image::where('port_id',$id)->get(); 

         return view('admin.work.work_detail.edit',['port' => $port,'categories'=>$categories,'port_images'=>$port_images]);
    }


    public function productInfoUpdate($work, $request, $imageUrl){
        $work->cat_id = $request->cat_id;
        $work->link = $request->link;
        $work->name=$request->name;
        $work->logo = $imageUrl;
        $work->save();
    }

    public function update(Request $request){
        $productImage = $request->file('logo');
        if($productImage){
            $work = Portfolio::find($request->id);
            unlink($work->logo);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($work, $request, $imageUrl);

            return redirect('work/detail/manage')->with('message','Updated Successfully');

        } else {
            $work = Portfolio::find($request->id);
            $work->cat_id = $request->cat_id;
            $work->name=$request->name;
            $work->link = $request->link;
           
            $work->save();

            return redirect('work/detail/manage')->with('message','Updated Successfully');
        }
    }


    public function port(Request  $request ){
          $id=$request->id;
          
         $ports =Portfolio_image::where('port_id',$id)->get();
          
        return view('front-end.portfolio.new',['ports'=>$ports]);

        //dd($ports);
        //$name =Portfolio::find($id);
    //     $addresses=Address::orderBy('id','DESC')
    //                  ->take(1)
    //                  ->get();
    //     $footers=Footer_v1::orderBy('id','DESC')
    //                  ->take(1)
    //                  ->get();
    //     $logos=Logo::where('status',1) 
    //              ->orderBy('id','DESC')
    //              ->take(1)
    //              ->get();
    //     $icons=Logo::where('status',0) 
    //              ->orderBy('id','DESC')
    //              ->take(1)
    //              ->get(); 
    //              $services=Service_cat::orderBy('id','ASC')
    //                  ->get();

    // return view('front-end.portfolio.design',['ports'=>$ports,'addresses'=>$addresses,'footers'=>$footers,'logos'=>$logos,'icons'=>$icons,'services'=>$services,'name'=>$name]);
    }

  public function editimage($id){

    $port = Portfolio_image::find($id);

    return view('admin.work.work_detail.image-edit',['port'=>$port]);
  }


   public function imageInfoUpdate($work, $request, $mainimageUrl){
       $work->image = $mainimageUrl;
        $work->save();
    }

    public function updateimage(Request $request){
        $imageName = $request->file('image');
        if($imageName){
            $work = Portfolio_image::find($request->id);
            unlink(realpath($imageName));

            $mainimageUrl = $this->imageUpload($request);
            $this->imageInfoUpdate($work, $request, $mainimageUrl);

            return redirect('work/detail/manage')->with('message','Updated Successfully');

        } else {
            $work = Portfolio::find($request->id);
             $work->save();
           return redirect('work/detail/manage')->with('message','Updated Successfully');
        }
    }

}
