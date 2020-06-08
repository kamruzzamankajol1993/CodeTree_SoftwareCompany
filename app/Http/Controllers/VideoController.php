<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;

class VideoController extends Controller
{
    public function showform(){
   	return view('admin.about.video.add');
   }

  protected function audioUpload($request){
        $audiofile = $request->file('file');
        $audioName = $audiofile->getClientOriginalName();
        $extension = $audiofile->getClientOriginalExtension();
        //$imageName = $productImage->getClientOriginalName();
       
        $directory = 'public/video-admin/';
        $audioUrl = $directory.$audioName;
    
        $audiofile->move($directory, $audioUrl);

        //Image::make($productImage)->resize(300,300)->save($imageUrl);

       return  $audioName;
    }



     protected function saveaudio($request, $audiofile){
     	$video = new Video();
        $video->title=$request->title;
        $video->file = $audiofile;
        $video->des=$request->des;
        $video->status = $request->status;
        if($video->save()){
            return redirect('/video/add')->with('message','Video Added Successfully');

        }

    }

    public function postaudio(Request $request){
        $request->validate([
            'title'=>'required',
            'file'=>'nullable',
            'des'=>'nullable',
            'status'=>'required',

        ]);
         $audiofile = $this->audioUpload($request);
        $this->saveaudio($request, $audiofile);

       return redirect('/video/add')->with('error','There have an error !!');
    }

    public function manageaudio(){
    	$videos = Video::paginate(10);
        return view('admin.about.video.manage',['videos' => $videos]);
    }

    public function deleteaudio($id){
        $video = Video::find($id);
        $video->delete();

        return redirect('/manage/video/')->with('message','Video deleted successfully');
    }

    public function unpublishedaudio($id){
        $video = Video::find($id);
        $video->status = 0;
        $video->save();

        return redirect('/manage/video/');
    }

    public function publishedaudio($id){
        $video = Video::find($id);
        $video->status = 1;
        $video->save();

        return redirect('/manage/video/');
    }
}
