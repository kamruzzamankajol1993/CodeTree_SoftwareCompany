<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\SLink;

use Image;

class TeamController extends Controller
{
    public function showform(){

    	return view('admin.about.team.team.add');
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
        $team = new Team();
        $team->name = $request->name;
        $team->title = $request->title;
        $team->image = $imageUrl;
       if($team->save()){
            return redirect('/add/member/')->with('message','Member Added Successfully');

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

       return redirect('/add/member/')->with('error','There have an error !!');

    }

    public function showlist(){
        $socials = SLink::paginate(10);
    	$teams = Team::paginate(10);
        return view('admin.about.team.team.manage',['teams' => $teams,'socials'=>$socials]);
    }

    public function deletenews($id){
        $team = Team::find($id);
        $team->delete();

        return redirect('/manage/member')->with('message','Member deleted successfully');
    }

    public function editnews($id){

        $team = Team::find($id);

         return view('admin.about.team.team.edit',['team' => $team]);
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
            $team = Team::find($request->id);
            unlink($team->image);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($team, $request, $imageUrl);

            return redirect('/manage/member')->with('message','Member Updated Successfully');

        } else {
            $team = Team::find($request->id);
            $team->name = $request->name;
            $team->title = $request->title;
            $team->save();
            return redirect('/manage/member')->with('message','Member Updated Successfully');
        }
    }

    
}
