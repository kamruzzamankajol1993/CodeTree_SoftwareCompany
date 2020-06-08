<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Team;
use App\Address;
use App\Footer_v1;
use App\Logo;
use App\Service_cat;
use App\Adviser;
use App\Software;

use DB;

class AboutController extends Controller
{
    public function showaboutpage(){

    	  $covervideos = Video::where('status',1)
                   ->orderBy('id','DESC')
                   ->take(1)
                   ->get();
        $covertitles = Video::where('status',1)
                   ->orderBy('id','DESC')
                   ->take(1)
                   ->get();
        $mainvideos = Video::where('status',0)
                   ->orderBy('id','DESC')
                   ->take(1)
                   ->get();
        $services=Service_cat::orderBy('id','ASC')
                     ->get();

        $mainteams = DB::table('teams')
                    ->join('s_links','teams.name','=','s_links.user_name')
                   ->select('teams.*','s_links.*')
                    ->get();
        $addresses=Address::orderBy('id','DESC')
                     ->take(1)
                     ->get();
        $footers=Footer_v1::orderBy('id','DESC')
                     ->take(1)
                     ->get();
        $logos=Logo::where('status',1) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();
        $icons=Logo::where('status',0) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get(); 
        $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();
        

    	return view('front-end.about.about.about',['msoftwares'=>$msoftwares,'mainteams'=>$mainteams,'addresses'=>$addresses,'footers'=>$footers,'logos'=>$logos,'icons'=>$icons,'covervideos'=>$covervideos,'covertitles'=>$covertitles,'mainvideos'=>$mainvideos,'services'=>$services]);
    }



    ///for team page

    public function showteampage(){

       $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();

      $services=Service_cat::orderBy('id','ASC')
                     ->get();

        $mainteams = DB::table('teams')
                    ->join('s_links','teams.name','=','s_links.user_name')
                   ->select('teams.*','s_links.*')
                    ->get();
        $addresses=Address::orderBy('id','DESC')
                     ->take(1)
                     ->get();
        $footers=Footer_v1::orderBy('id','DESC')
                     ->take(1)
                     ->get();
        $logos=Logo::where('status',1) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();
        $icons=Logo::where('status',0) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get(); 
                 $advisers=Adviser::orderBy('id','ASC')
                     ->get();
      return view('front-end.about.team.team',['msoftwares'=>$msoftwares,'mainteams'=>$mainteams,'addresses'=>$addresses,'footers'=>$footers,'logos'=>$logos,'icons'=>$icons,'services'=>$services,'advisers'=>$advisers]);
    }
}
