<?php
namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Author;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Exception;
class AuthorsController extends Controller
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
      if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $data['active_class']        = 'library';
        $data['title']               = getPhrase('authors');
        $data['layout']              = getLayout();
        $data['module_helper']       = getModuleHelper('authors-list');
    	return view('library.authors.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {

         $records = Author::select([   
         	'author', 'gender', 'description', 'id','slug']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         

            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_AUTHORS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                            
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->editColumn('gender', function($records){
        	return ucfirst($records->gender);
        })
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
        if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$data['record']         	= FALSE;
        $data['active_class']       = 'library';
    	$data['layout']             = getLayout();
    	$data['title']              = getPhrase('create_authors');
        $data['module_helper']      = getModuleHelper('authors-create');
    	return view('library.authors.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
        if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$record = Author::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']       = 'library';
    	$data['title']              = getPhrase('edit_author');
        $data['layout']             = getLayout();
    	return view('library.authors.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
    	$record = Author::getRecordWithSlug($slug);
		$rules = [
         'author'          	   => 'bail|required|max:30' ,
          ];
         /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
       $name = $request->author;
        if($name != $record->author)
            $record->slug = $record->makeSlug($name);
      
       //Validate the overall request
       $this->validate($request, $rules);
        $record->author 			= $name;
        $record->gender				= $request->gender;
        $record->description		= $request->description;
        $record->record_updated_by 	= Auth::user()->id;
        $record->save();
 
        flash('success','record_updated_successfully', 'success');
    	return redirect('library/authors');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
	    $rules = [
         'author'          	   => 'bail|required|max:30' ,
            ];
        $record = new Author();
      	$name  						=  $request->author;
		$record->author 			= $name;
       	$record->slug 				= $record->makeSlug($name);
        $record->gender				= $request->gender;
        $record->description		= $request->description;
        $record->record_updated_by 	= Auth::user()->id;
        $record->save();
 
        flash('success','record_added_successfully', 'success');
    	return redirect('library/authors');
    }
 
    
    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }


       try{
        if(!env('DEMO_MODE')) {
            Author::where('slug', $slug)->delete();
           }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
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
    	return URL_AUTHORS;
    }

}

 