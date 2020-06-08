<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service_cat;
use App\Service_subcat;

use Image;
use DB;

class MainsController extends Controller
{
    public function showform(){

    	return view('admin.service.service_cat.add');
    }


    

     public function addnews(Request $request){
        $service_cat = new Service_cat();
        $service_cat->name = $request->name;
       if($service_cat->save()){
            return redirect('/add/servicenew/')->with('message','Added Successfully');

        }
    }

     

    public function showlist(){
    	$headlines = Service_cat::paginate(10);
        return view('admin.service.service_cat.manage',['headlines' => $headlines]);
    }

    public function deletenews($id){
        $headline = Service_cat::find($id);
        $headline->delete();

        return redirect('/manage/servicenew')->with('message','Deleted successfully');
    }

    public function editnews($id){

        $news = Service_cat::find($id);

         return view('admin.service.service_cat.edit',['news' => $news]);
    }


    

    public function updatenews(Request $request){
       
            $headline = Service_cat::find($request->id);
            $headline->name = $request->name;
            $headline->save();
            return redirect('/manage/servicenew')->with('message','Updated Successfully');
        
    }



    //service sub-category section

    public function show(){
        $categories = Service_cat::all();
        return view('admin.service.service_subcat.add',['categories' => $categories]);
    }


     public function add(Request $request){
        $service_subcat = new Service_subcat();
        $service_subcat->cat_id = $request->cat_id;
        $service_subcat->sub_name = $request->sub_name;
        $service_subcat->price = $request->price;
       if($service_subcat->save()){
            return redirect('/add/servicesub/')->with('message','Added Successfully');

        }
    }


     public function showsublist(){
        $subs = Service_cat::all();
       $headlines = DB::table('service_subcats')
          ->join('service_cats', 'service_cats.id', '=', 'service_subcats.cat_id')
          ->select('service_subcats.*','service_cats.name')
                    ->paginate(10);
        return view('admin.service.service_subcat.manage',['headlines' => $headlines,'subs'=>$subs]);
    }

    public function deletesubcat($id){
        $headline = Service_subcat::find($id);
        $headline->delete();

        //$port = Service_cat::where('id',$id);
        //$port->delete();

        return redirect('/manage/servicesub')->with('message','Deleted successfully');
    }

    public function editsubcat($id){
        $categories = Service_cat::all();

        $news = Service_subcat::find($id);

         return view('admin.service.service_subcat.edit',['news' => $news,'categories' => $categories]);
    }


    

    public function updatesubcat(Request $request){
       
            $service_subcat = Service_subcat::find($request->id);
            $service_subcat->cat_id = $request->cat_id;
              $service_subcat->sub_name = $request->sub_name;
        $service_subcat->price = $request->price;
            $service_subcat->save();
            return redirect('/manage/servicesub')->with('message','Updated Successfully');
        
    }


}
