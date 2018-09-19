<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Religion;
use Yajra\Datatables\Datatables;
use DB;
use Exception;
class ReligionsController extends Controller
{
    
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Fee categories listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('religions');
        $data['layout']              = getLayout();
    	return view('mastersettings.religions.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {

         $records = Religion::select(['id','religion_name','slug']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_MASTERSETTINGS_RELIGIONS_EDIT.''.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
    	$data['record']         	= FALSE;
    	$data['active_class']       = 'master_settings';
    	$data['title']              = getPhrase('add_religion');
        $data['layout']              = getLayout();
    	return view('mastersettings.religions.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
    	$record = Religion::where('slug', $slug)->get()->first();
    	$data['record']       		= $record;
    	$data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('edit_religion');
        $data['layout']              = getLayout();
    	return view('mastersettings.religions.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

        $record                 = Religion::where('slug', $slug)->get()->first();
        
          $this->validate($request, [
            'religion_name'          => 'bail|required|max:30|unique:religions,religion_name,'.$record->id.''
            ]);

        	$name                       = $request->religion_name;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->religion_name)
            $record->slug = $record->makeSlug($name);
    	
        $record->religion_name = $name;
         
        $record->save();
    	flash('success','record_updated_successfully', 'success');
    	return redirect('mastersettings/religions');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
         'religion_name'          => 'bail|required|max:30|unique:religions,religion_name'
            ]);
    	$record = new Religion();
        $name 					        = $request->religion_name;
        $record->religion_name 			= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('mastersettings/religions');
    }

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
      try{
        if(!env('DEMO_MODE')) {
            Religion::where('slug', $slug)->delete();
        }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
        }
        catch (Exception $e) {
                 $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
       }
       return json_encode($response);
    }
}
