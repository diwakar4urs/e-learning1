<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use Yajra\Datatables\Datatables;
use DB;
use Exception;
class CategoriesController extends Controller
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
        $data['title']              = getPhrase('categories');
        $data['layout']              = getLayout();
    	return view('mastersettings.categories.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {

         $records = Category::select(['id','category_name','slug']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_MASTERSETTINGS_CATEGORIES_EDIT.''.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
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
    	$data['title']              = getPhrase('add_Category');
        $data['layout']             = getLayout();
    	return view('mastersettings.categories.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
    	$record = Category::where('slug', $slug)->get()->first();
    	$data['record']       		= $record;
    	$data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('edit_Category');
        $data['layout']             = getLayout();
    	return view('mastersettings.categories.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

        $record                 = Category::where('slug', $slug)->get()->first();
        
          $this->validate($request, [
            'category_name'          => 'bail|required|max:40|unique:categories,category_name,'.$record->id.''
            ]);

        	$name                       = $request->category_name;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->category_name)
            $record->slug = $record->makeSlug($name);
    	
        $record->category_name = $name;
         
        // $record->slug                   = $record->makeSlug($name);
       
        $record->save();
    	flash('success','record_updated_successfully', 'success');
    	return redirect('mastersettings/categories');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
         'category_name'          => 'bail|required|max:40|unique:categories,category_name'
            ]);
    	$record = new Category();
        $name 					        = $request->category_name;
        $record->category_name 			= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('mastersettings/categories');
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
                Category::where('slug', $slug)->delete();
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
