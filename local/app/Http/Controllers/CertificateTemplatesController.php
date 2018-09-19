<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\CertificateTemplate;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class CertificateTemplatesController extends Controller
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
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('certificate_templates');
        $data['layout']             = getLayout();
    	return view('certificates.templates.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug = '')
    {
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
       
         $records = CertificateTemplate::select([   
         	'title', 'subject', 'type',  'id','slug'])
         ->orderBy('updated_at', 'desc');
       
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         

            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                        
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
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$data['record']         	= FALSE;
    	$data['active_class']       = 'master_settings';
    	$data['title']              = getPhrase('create_template');
        $data['layout']             = getLayout();
    	return view('certificates.templates.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
        // dd($slug);
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$record = CertificateTemplate::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']       = 'master_settings';
    	$data['title']              = getPhrase('edit_template');
        $data['layout']             = getLayout();
    	return view('certificates.templates.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
        // dd($request);
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = CertificateTemplate::getRecordWithSlug($slug);
		 $rules = [
         'title'          	   => 'bail|required|max:30' ,
         'subject'             => 'bail|required' ,
         ];
         /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
       $name = $request->title;
        if($name != $record->title)
            $record->slug = $record->makeSlug($name);
      
       //Validate the overall request
        $this->validate($request, $rules);
        $record->title              = $request->title;
        $record->content            = $request->content;
        $record->type               = $request->type;
        $record->subject            = $request->subject;
        $record->updated_by         = Auth::user()->id;
        $record->save();

        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES);
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
        // dd($request);   
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
       
	    $rules = [
         'title'          	   => 'bail|required|max:30' ,
         'subject'             => 'bail|required|max:30' ,
         
            ];
        $this->validate($request, $rules);
        $record = new CertificateTemplate();
      	$name  						= $request->title;
		$record->title 			    = $name;
       	$record->slug 				= $record->makeSlug($name);
        $record->content			= $request->content;
        $record->type				= $request->type;
        $record->subject			= $request->subject;
        $record->updated_by 	    = Auth::user()->id;
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES);
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
    	return URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES;
    }
   
}
