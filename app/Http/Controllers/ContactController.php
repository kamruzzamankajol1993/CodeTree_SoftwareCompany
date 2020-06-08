<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Address;
use App\Logo;
Use App\Footer_v1;
use App\Service_cat;
use App\Software;

class ContactController extends Controller
{
    public function send(Request $request){

    	$request->validate([

             'name'=>'required',
             'email' => 'required | regex:/^.+@.+$/i',
             'des'=>'required',
             
             
             
            
           
        ]);

    	$contact = new Contact();
    	$contact->name = $request->name;
    	$contact->email = $request->email;
    	$contact->des = $request->des;
    	$contact->save();

   	return redirect('/')->with('message','Send Succesfully');
    }


     public function manage(){

	$contacts = Contact::paginate(10);
    	 return view('admin.message.message',['contacts' => $contacts]);
    }

     public function delete($id){
        $contact = Contact::find($id);
        $contact->delete();

        return redirect('/contact/manage')->with('message','Deleted successfully');
    }


    //contact page section

       public function sendmain(Request $request){

        $request->validate([

             'name'=>'required',
             'email'=>'required',
             'des'=>'required',
             
             
             
            
           
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->des = $request->des;
        $contact->save();

    return redirect('/contact/main')->with('message','Send Succesfully');
    }

    public function show_main_page(){

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
                 $services=Service_cat::orderBy('id','ASC')
                     ->get();

                     $msoftwares=Software::where('status',1) 
                 ->orderBy('id','DESC')
                 ->take(1)
                 ->get();

    return view('front-end.contact.contact',['msoftwares'=>$msoftwares,'addresses'=>$addresses,'footers'=>$footers,'logos'=>$logos,'icons'=>$icons,'services'=>$services]);
    }
}
