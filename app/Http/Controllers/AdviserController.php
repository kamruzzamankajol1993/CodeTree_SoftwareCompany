<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adviser;
use Image;

class AdviserController extends Controller
{
    public function showform(){

    	return view('admin.adviser.add');
    }

    protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'member-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(540,540)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $team = new Adviser();
        $team->name = $request->name;
        $team->title = $request->title;
        $team->image = $imageUrl;
       if($team->save()){
            return redirect('/add/adviser/')->with('message','Adviser Added Successfully');

        }
    }

     public function addnews(Request $request){
        $request->validate([

            'name'=>'nullable',
            'title'=>'nullable',
           'image'=>'required',
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

       return redirect('/add/adviser/')->with('error','There have an error !!');

    }

    public function showlist(){
        
    	$teams = Adviser::paginate(10);
        return view('admin.adviser.manage',['teams' => $teams]);
    }

    public function deletenews($id){
        $team = Adviser::find($id);
        $team->delete();

        return redirect('/manage/adviser')->with('message','Adviser deleted successfully');
    }

    public function editnews($id){

        $team = Adviser::find($id);

         return view('admin.adviser.edit',['team' => $team]);
    }


    public function productInfoUpdate($team, $request, $imageUrl){
    	$team->name = $request->name;
        $team->title = $request->title;
        $team->image = $imageUrl;
        $team->save();
    }

    public function updatenews(Request $request){
        $productImage = $request->file('image');
        if($productImage){
            $team = Adviser::find($request->id);
            unlink($team->image);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($team, $request, $imageUrl);

            return redirect('/manage/adviser')->with('message','Adviser Updated Successfully');

        } else {
            $team = Adviser::find($request->id);
            $team->name = $request->name;
            $team->title = $request->title;
            $team->save();
            return redirect('/manage/adviser')->with('message','Adviser Updated Successfully');
        }
    }
}
