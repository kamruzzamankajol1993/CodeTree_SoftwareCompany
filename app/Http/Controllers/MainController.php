<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Headline;
use App\Portfolio;
use App\Portfolio_image;
use App\Share;
use App\Count;
use App\Feature;
use App\Offer;
use App\Logo;
use App\Client1;
use App\Banner;
use App\Address;
use App\Footer_v1;
use App\Service_cat;
use App\Software;

use DB;

class MainController extends Controller
{
  public function show_main_page(){

    $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 
                 ->get();

     //$ports =Portfolio_image::where('port_id',$id)->get();
  	$headlines=Headline::orderBy('id','DESC')
    	            
    	            ->get();
    $services=Service_cat::orderBy('id','ASC')
                     ->get();
    $clients=Client1::orderBy('id','DESC')
                    ->get();
    $banners=Banner::orderBy('id','DESC')
                    ->take(1)
                    ->get();
    $addresses=Address::orderBy('id','DESC')
                     ->take(1)
                     ->get();
     $footers=Footer_v1::orderBy('id','DESC')
                     ->take(1)
                     ->get();               

    $titles = DB::table('headlines')
                 ->orderBy('id','DESC')
                 ->select('title')
                 ->take(1)
                 ->get();
    $softwares=Portfolio::where('cat_id','3')
                ->orderBy('id','DESC')
                ->take(18)
                ->get();

    $username ="Web Design & Development";
    $username1 ="Web Development & Design";

   /*$softwares = DB::table('work1s')
               ->where('cat_name','LIKE','%'.$username1.'%'.'%'.$username.'%')
                 ->get();*/
    $apps=Portfolio::where('cat_id','4')
                ->orderBy('id','DESC')
                ->take(18)
                ->get();
    $designs=Portfolio::where('cat_id','7')
                ->orderBy('id','DESC')
                ->take(18)
                ->get();
    $markets=Portfolio::where('cat_id','6')
                ->orderBy('id','DESC')
                ->take(18)
                ->get();
    $shares=Share::orderBy('id','DESC')
                  ->take(1)
                  ->get();
    $features=Feature::orderBy('id','ASC')
                ->get();
    $counts=Count::orderBy('id','ASC')
                ->get();
     $offers=Offer::orderBy('id','ASC')
                ->get();
     $logos=Logo::where('status',1) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();
      $icons=Logo::where('status',0) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();  
            


  return view('front-end.home.index',['msoftwares'=>$msoftwares,'headlines'=>$headlines,'titles'=>$titles,'softwares'=>$softwares,'apps'=>$apps,'designs'=>$designs,'shares'=>$shares,'features'=>$features,'counts'=>$counts,'offers'=>$offers,'logos'=>$logos,'icons'=>$icons,'clients'=>$clients,'banners'=>$banners,'addresses'=>$addresses,'footers'=>$footers,'services'=>$services,'markets'=>$markets]);
  }
}
