<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\SLink;

class SocialController extends Controller
{
    public function showsocialform($id){
    	$users = Team::find($id);
    	return view('admin.about.team.social.add',[
            'users' => $users
            
        ]);
    }

     public function savesocial(Request $request){

     	 $request->validate([

             'user_name'=>'required',
             'f_link'=>'required',
             'ins_link'=>'nullable',
             'linkin_link'=>'nullable',
             'git_link'=>'nullable',
             'you_link'=>'nullable',
             'pin_link'=>'nullable',

            
           
        ]);

    	$slink = new SLink();
    	$slink->user_name = $request->user_name;
    	$slink->f_link = $request->f_link;
    	$slink->ins_link = $request->ins_link;
   	    $slink->linkin_link = $request->linkin_link;
        $slink->git_link = $request->git_link;
        $slink->you_link = $request->you_link;
        $slink->pin_link = $request->pin_link;
   	    $slink->save();

   	return redirect('/manage/member')->with('message','Link saved succesfully');
    }

    public function showsociallist(){

    	$socials = SLink::paginate(10);
    	 return view('admin.about.team.team.manage',['socials' => $socials]);
    }

    public function editsocial($id){

    	$social = SLink::find($id);
        $users = Team::all();
         return view('admin.about.team.social.edit',['social' => $social,'users'=>$users]);
    }

    public function updatesocial(Request $request){
    	$slink = SLink::find($request->id);
        $slink->user_name = $request->user_name;
    	$slink->f_link = $request->f_link;
    	$slink->ins_link = $request->ins_link;
   	    $slink->linkin_link = $request->linkin_link;
        $slink->git_link = $request->git_link;
        $slink->you_link = $request->you_link;
        $slink->pin_link = $request->pin_link;
   	    $slink->save();
   	     return redirect('/manage/member')->with('message','Link Updated Successfully');
    }

    public function deletesocial($id){
        $slink = SLink::find($id);
        $slink->delete();

        return redirect('/manage/member')->with('message','Link deleted successfully');
    }
}
