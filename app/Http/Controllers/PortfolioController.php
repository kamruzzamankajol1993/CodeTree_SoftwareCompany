<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logo;
use App\Footer_v1;
use App\Address;
use App\Work1;
use App\Service_cat;
use App\Portfolio;
use App\Software;

class PortfolioController extends Controller
{
    public function show_front_page(){

        
        $logos=Logo::where('status',1) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();
        $services=Service_cat::orderBy('id','ASC')
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
        $softwares=Portfolio::where('cat_id','3')
                ->orderBy('id','DESC')
                ->get();

    $username ="Web Design & Development";
    $username1 ="Web Development & Design";

   /*$softwares = DB::table('work1s')
               ->where('cat_name','LIKE','%'.$username1.'%'.'%'.$username.'%')
                 ->get();*/
    $apps=Portfolio::where('cat_id','4')
                ->orderBy('id','DESC')
                ->get();
    $designs=Portfolio::where('cat_id','7')
                ->orderBy('id','DESC')
                ->get();
    $markets=Portfolio::where('cat_id','6')
                ->orderBy('id','DESC')
                ->get();
    //$mars=Work1::where('cat_name','Digital Marketing')
                //->orderBy('id','DESC')
                //->get();
      $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();

       return view('front-end.portfolio.portfolio',['msoftwares'=>$msoftwares,'logos'=>$logos,'icons'=>$icons,'addresses'=>$addresses,'footers'=>$footers,'softwares'=>$softwares,'apps'=>$apps,'designs'=>$designs,'services'=>$services,'markets'=>$markets]);
    }
}
