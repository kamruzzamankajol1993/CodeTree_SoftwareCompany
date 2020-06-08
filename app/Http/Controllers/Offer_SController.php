<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Headline;
use App\Logo;
use App\Footer_v1;
use App\Address;
use App\Service_cat;

use DB;

class Offer_SController extends Controller
{
	public function show_page(){


     $addresses=Address::orderBy('id','DESC')
                     ->take(1)
                     ->get();
     $services=Service_cat::orderBy('id','ASC')
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
     $details=DB::table('services')
                   ->get();

     $details_c=DB::table('needs')
                   ->get();


             return view('front-end.offer.offer',['logos'=>$logos,'icons'=>$icons,'addresses'=>$addresses,'footers'=>$footers,'details'=>$details,'details_c'=>$details_c,'services'=>$services]);


                 }
}
