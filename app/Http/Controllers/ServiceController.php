<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Logo;
use App\Footer_v1;
use App\Mains;

class ServiceController extends Controller
{
    public function show(){

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
        $services=Mains::orderBy('id','DESC')
                    ->get();

    	return view('front-end.service.service',['addresses'=>$addresses,'footers'=>$footers,'logos'=>$logos,'icons'=>$icons,'services'=>$services]);
    }
}
