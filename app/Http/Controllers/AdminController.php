<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    public function showloginform(Request $request){

          if($request->isMethod('post')){
              $data =$request->input();
              if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                  //Session::put('adminSession',$data['email']);
                  return redirect('/homepage');
              }else{
                return redirect('/adminlogin')->with('flash_message_error','Invalid User Name or Password');
              }
          }

        return view('admin.login.login');
    }

    public function homepage(){
        /*if(Session::has('adminSession')){
            
        }else{
            return redirect('/adminlogin')->with('flash_message_error','Please login to access');
        }*/
        return view('admin.home.home');
    }
    public function logout(){
        Session::flush();
        return redirect('/adminlogin')->with('flash_message_success','You are successfully logout');
    }
}
