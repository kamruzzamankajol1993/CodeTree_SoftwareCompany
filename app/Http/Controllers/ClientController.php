<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client1;

use Image;

class ClientController extends Controller
{
   public function showform(){

    	return view('admin.client.add');
    }


    protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'news-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(960,540)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $client = new Client1();
        $client->name = $request->name;
        $client->title = $request->title;
        $client->com = $request->com;
        $client->link = $request->link;
        $client->c_name = $request->c_name;
        $client->image = $imageUrl;
       if($client->save()){
            return redirect('/add/client/')->with('message','Added Successfully');

        }
    }

     public function addnews(Request $request){
        $request->validate([

            
            'title'=>'required',
             'name'=>'required',
             'com'=>'required',
             'link'=>'required',
             'c_name'=>'required',
            'image'=>'required',
           
        ]);
        //$this->validateproduct($request);
         $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

       return redirect('/add/client/')->with('error','There have an error !!');

    }

    public function showlist(){
    	$clients = Client1::paginate(10);
        return view('admin.client.manage',['clients' => $clients]);
    }

    public function deletenews($id){
        $client = Client1::find($id);
        $client->delete();

        return redirect('/manage/client')->with('message','Deleted successfully');
    }

    public function editnews($id){

        $client = Client1::find($id);

         return view('admin.client.edit',['client' => $client]);
    }


    public function productInfoUpdate($client, $request, $imageUrl){
        $client->name = $request->name;
        $client->title = $request->title;
        $client->com = $request->com;
        $client->link = $request->link;
        $client->c_name = $request->c_name;
        $client->image = $imageUrl;
        $client->save();
    }

    public function updatenews(Request $request){
        $productImage = $request->file('image');
        if($productImage){
            $client = Client1::find($request->id);
            unlink($client->image);

            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($client, $request, $imageUrl);

            return redirect('/manage/client')->with('message','Updated Successfully');

        } else {
            $client = Client1::find($request->id);
            $client->name = $request->name;
        $client->title = $request->title;
        $client->com = $request->com;
        $client->link = $request->link;
        $client->c_name = $request->c_name;
           
            $client->save();

            return redirect('/manage/client')->with('message','Updated Successfully');
        }
    }
}
