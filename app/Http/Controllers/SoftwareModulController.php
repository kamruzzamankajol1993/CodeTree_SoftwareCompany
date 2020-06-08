<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Software;
use App\Softwaremodule;
use App\Logo;
use App\Address;
use App\Footer_v1;
use App\Service_cat;

use Image;
use DB;

class SoftwareModulController extends Controller
{
    public function showform(){

    	$softwares = software::all();

    	return view('admin.software.module.add',['softwares'=>$softwares ]);
    }


    public function saveform(Request $request){


		$request->validate([

             'soft_id'=>'required',
             'module_name'=>'required'
             
            ]);

		$number=count($request->module_name);

        if($number >0){
            for($i=0;$i<$number;$i++){
                $data=array([
                    'module_name'=>$request->module_name[$i],
                     'soft_id'=>$request->soft_id
                ]);
                
              Softwaremodule::insert($data);
            }

        }

    return redirect()->back()->with('message','Name saved succesfully');
	}

  public function showsoftwarelist(){

    $softwaremodules = DB::table('softwaremodules')
          ->join('software','software.id','=','softwaremodules.soft_id')
          ->select('softwaremodules.id as moduleId','softwaremodules.module_name','softwaremodules.soft_id','software.*')->paginate(10); 
       return view('admin.software.module.manage',['softwaremodules'=>$softwaremodules]);
  }


  public function editsoftware($id){

      $detail = Softwaremodule::find($id);
      
         return view('admin.software.module.edit',['detail' => $detail]);
    }


       public function updatesoftware(Request $request){
        $request->validate([

        'module_name' => 'required',
        
      ]);
      DB::table('softwaremodules')->where('id',$request->id)->update(['module_name'=>$request->module_name]);
      return redirect('/software/module/manage')->with('message','Name update succesfully');
       }


       public function deletesoftware($id){
        $count = Softwaremodule::find($id);
        $count->delete();

        return redirect('/software/module/manage')->with('message','Deleted successfully');
    }

}
