<?php


namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use Yajra\Datatables\Datatables;
use DB;
use App\OfflineQuizCategories;
use Exception;
class OfflineQuizCategoriesController extends Controller
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
        $data['active_class']       = 'exams';
        $data['title']              = getPhrase('offline_quiz_categories');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('list');

    	return view('offlineexams.quizcategories.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {

         $records = OfflineQuizCategories::select(['id','title','slug']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_OFFLINEEXMAS_QUIZ_CATEGORIES_EDIT.''.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
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
    	$data['active_class']       = 'exams';
    	$data['title']              = getPhrase('add_Category');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('create-category');
    	return view('offlineexams.quizcategories.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
    	$record = OfflineQuizCategories::where('slug', $slug)->get()->first();
    	$data['record']       		= $record;
    	$data['active_class']       = 'exams';
        $data['title']              = getPhrase('edit_Category');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('create-category');
    	return view('offlineexams.quizcategories.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

        $record                 = OfflineQuizCategories::where('slug', $slug)->get()->first();
        
          $this->validate($request, [
            'title'          => 'bail|required|max:40|unique:quizofflinecategories,title,'.$record->id.''
            ]);

        	$name                       = $request->title;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->title)
            $record->slug = $record->makeSlug($name);
    	
        $record->title = $name;
         
        $record->save();
    	flash('success','record_updated_successfully', 'success');
    	return redirect('offlineexmas/quiz/categories');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
         'title'          => 'bail|required|max:40|unique:quizofflinecategories,title'
            ]);
    	$record  =   new OfflineQuizCategories();
        $name 					        = $request->title;
        $record->title 			        = $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('offlineexmas/quiz/categories');
    }

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        try{

          $record = OfflineQuizCategories::where('slug', $slug)->first();

          $count = App\Quiz::where('type','=','offline')
                            ->where('offline_quiz_category_id', '=', $record->id)
                            ->count();
         if($count==0){
        if(!env('DEMO_MODE')) {
          $record->delete();
         }
          $response['status'] = 1;
          $response['message'] =  getPhrase('record_deleted_successfully');
        }
        else{
          $response['status'] = 0;
          $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
        }

        }
          catch(Exception $e){
            $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
          }
        return json_encode($response);
    }
    
}
