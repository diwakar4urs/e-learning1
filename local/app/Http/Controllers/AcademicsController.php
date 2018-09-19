<?php
namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Academic;
use Yajra\Datatables\Datatables;
use DB;
use Exception; 

class AcademicsController extends Controller
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
        $data['active_class']        = 'master_settings';
        $data['title']               = getPhrase('academic_years');
        $data['layout']              = getLayout();
        $data['module_helper']       = getModuleHelper('academic-year');
        return view('mastersettings.academics.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
        DB::statement(DB::raw('set @rownum=0'));

         $records = Academic::select([ 'id','academic_year_title','academic_start_date','academic_end_date','slug']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="'.URL_MASTERSETTINGS_ACADEMICS_COURSES.$records->slug.'"><i class="fa fa-book"></i>'.getPhrase("allocate_courses").'</a></li>

                            <li><a href="'.URL_MASTERSETTINGS_ACADEMICS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>

                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        ->editColumn('academic_year_title',function($records)
        {
            return '<a href="'.URL_MASTERSETTINGS_ACADEMICS_COURSES.$records->slug.'">'.$records->academic_year_title.' ('.$records->id.')'.'</a>';
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
    	$data['title']              = getPhrase('add_academic');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('add-academic');
        return view('mastersettings.academics.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
    	$record = Academic::where('slug', $slug)->get()->first();
    	$data['record']       		= $record;
    	$data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('edit_academic');
        $data['layout']              = getLayout();
        $data['module_helper']      = getModuleHelper('add-academic');
    	return view('mastersettings.academics.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

        $record                 = Academic::where('slug', $slug)->get()->first();
        
          $this->validate($request, [
            'academic_year_title'          => 'bail|required|max:20|unique:academics,academic_year_title,'.$record->id,
         	'academic_start_date'			=> 'required',
         	'academic_end_date'			=> 'required',
            ]);

        	$name                       = $request->academic_year_title;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->academic_year_title)
            $record->slug = $record->makeSlug($name);
    	
        $record->academic_year_title 	= $name;
        $record->academic_start_date 	= $request->academic_start_date;
        $record->academic_end_date      = $request->academic_end_date;
        $record->show_in_list 		    = $request->show_in_list;
        
        $record->save();
    	flash('success','record_updated_successfully', 'success');
    	return redirect('mastersettings/academics');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)

    {
       $this->validate($request, [
         'academic_year_title'          => 'bail|required|max:40|unique:academics,academic_year_title',
         'academic_start_date'			=> 'required',
         'academic_end_date'			=> 'required',
            ]);
    	$record = new Academic();
        $name 					        = $request->academic_year_title;
        $record->academic_year_title 	= $name;
        $record->academic_start_date 	= $request->academic_start_date;
        $record->academic_end_date 		= $request->academic_end_date;
        $record->slug 			        = $record->makeSlug($name);
        $record->show_in_list           = $request->show_in_list;
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('mastersettings/academics');
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
                Academic::where('slug', $slug)->delete();
            }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
        }
        catch(Exception $e)
        {
           $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
        }
        return json_encode($response);
    }

    public function getAcademics()
    {
        return array_pluck(Academic::all(), 'academic_year_title', 'id');
    }
}
