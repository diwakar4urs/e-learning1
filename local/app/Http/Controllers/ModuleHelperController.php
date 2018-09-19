<?php

namespace App\Http\Controllers;

use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Settings;
use App\ModuleHelper;
use Yajra\Datatables\Datatables;
use DB;
use Input;


class ModuleHelperController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {

      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('modules_helper');
    	return view('mastersettings.module-helper.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }

         $records = ModuleHelper::select([ 'title', 
            'slug', 'help_link_text','is_enabled','id', 'updated_at'])
         ->orderBy('updated_at','desc');

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_MODULEHELPERS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                            <li><a href="'.URL_MODULEHELPERS_VIEW.$records->slug.'"><i class="fa fa-eye"></i>'.getPhrase("view").'</a></li>';
                     
                        
                    $temp = '';
                   
                    $temp .=    '</ul></div>';
                    $link_data .= $temp;

            return $link_data;
            })
        ->editColumn('title', function($records){
        	return '<a href='.URL_MODULEHELPERS_VIEW.$records->slug.'>'.ucwords($records->title).'</a>';
        })
        ->editColumn('is_enabled', function($records){
        	return ($records->is_enabled) ? '<i class="fa fa-check text-success" title="Active" ></i>' : '<i class="fa fa-times text-danger" title="Inactive"></i>';
        })
        ->removeColumn('id')
    
        ->removeColumn('updated_at')
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
        
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$data['record']         	= FALSE;
    	$data['active_class']       = 'master_settings';
    	$data['title']              = getPhrase('add_helper');
    	$data['layout']             = getLayout();
    	return view('mastersettings.module-helper.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {

      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = ModuleHelper::where('slug', $slug)->get()->first();
    	
    	if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

    	$data['record']       		= $record;
    	
    	$data['active_class']       = 'master_settings';
    	$data['layout']       = getLayout();
        $data['title']              = getPhrase('edit_settings');
    	return view('mastersettings.module-helper.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
     if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $record                 = ModuleHelper::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $record->title                  = $request->title;
        $record->slug 					= $request->slug;
        $record->help_link_text         = $request->help_link_text;
        $record->help_link_url 		    = $request->help_link_url;
        $record->is_enabled 			= $request->has('is_enabled') ? 1: 0 ;
        $settings['keyboard'] 			= $request->has('keyboard') ? 1:0;
        $settings['backdrop'] 			= $request->has('backdrop')? 1 : 0;
        $record->settings 				= json_encode($settings);
        
        $record->save();

       
    	flash('success','record_updated_successfully', 'success');
    	return redirect(URL_MODULEHELPERS_LIST);
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
     if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }

       $this->validate($request, [
         'slug'          	 	=> 'bail|required|max:50|unique:modulehelper,slug',
         'title'                => 'bail|required',
         'help_link_text'       => 'bail|required',
         ]);
    	$record 						= new ModuleHelper();
        $record->title                  = $request->title;
        $record->slug 					= $request->slug;
        $record->help_link_text         = $request->help_link_text;
        $record->help_link_url 		    = $request->help_link_url;
 		$record->is_enabled 			= $request->has('is_enabled') ? 1: 0 ;
        $settings['keyboard'] 			= $request->has('keyboard') ? 1:0;
        $settings['backdrop'] 			= $request->has('backdrop')? 1 : 0;
        $record->settings 				= json_encode($settings);
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_MODULEHELPERS_LIST);
    }

     
   

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        $record = ModuleHelper::where('slug', $slug)->first();
      
        $record->delete();
        $response['status'] = 1;
        $response['message'] = getPhrase('record_deleted_successfully');
        return json_encode($response);
       
    }

    public function viewSettings($slug)
    {
 
        if(!checkRole(getUserGrade(1)))
        {
            prepareBlockUserMessage();
            return back();
        }

        $record                 = ModuleHelper::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);
     	
       $data['settings_data']      = getArrayFromJson($record->steps);
       $data['record']             = $record;
       $data['active_class']       = 'master_settings';
       $data['title']              = $record->title.' '.getPhrase('steps');
       $data['layout']             = getLayout();
       return view('mastersettings.module-helper.steps-list', $data);
    }

   
    /**
     * This method is used to update the subsettings of the settings module
     * 
     * @param  Request $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
    public function updateSteps(Request $request, $slug)
    {
   	        
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
      $record                 = ModuleHelper::where('slug', $slug)->get()->first();
    
      if($isValid = $this->isValidRecord($record))
        return redirect($isValid);

         $sort_order_list 	= $request->sort_order_list;
         $elements_list 	= $request->elements_list;
         $titles_list 		= $request->titles_list;
         $contents_list 	= $request->contents_list;
         $placements_list 	= $request->placements_list;
         $id_list 			= $request->id_list;
         $index 			= 0;
         $steps 			= [];
       foreach($sort_order_list as $element)
       {
       	$temp['id'] 		= $id_list[$index];
       	$temp['element'] = $elements_list[$index];
       	$temp['title'] 		= $titles_list[$index];
       	$temp['content'] 	= $contents_list[$index];
       	$temp['placement'] 	= $placements_list[$index];
       	$temp['sort_order'] = $element;
       	$index++;
       	$steps[] 			= $temp;
       }

       $record->steps = json_encode($steps);
      
       $record->save();

       flash('success','record_updated_successfully', 'success');
    	return back();

    }
 

    public function isValidRecord($record)
    {
      if ($record === null) {

        flash('Ooops...!', getPhrase("page_not_found"), 'error');
        return $this->getRedirectUrl();
    }

    return FALSE;
    }

    public function getReturnUrl()
    {
      return URL_SETTINGS_LIST;
    }

 
 
}
