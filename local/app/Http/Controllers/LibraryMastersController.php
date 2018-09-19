<?php
namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\LibraryAssetType;
use App\LibraryMaster;
use App\LibrarySettings;
use App\LibraryInstance;
use App\Publisher;
use App\Author;
use App\User;
use App\Student;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Image;
use ImageSettings;
use File;
use Illuminate\Support\Facades\Validator;
use DNS1D;
use DNS2D;
use Exception;
class LibraryMastersController extends Controller
{
         
    public function __construct()
    {
    	$this->middleware('auth');
    }
   
    protected  $librarySettings;

    public function setLibrarySettings()
    {
        $this->librarySettings = getLibrarySettings();
    }

    public function getLibrarySettings()
    {
        return $this->librarySettings;
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
        
        
        $data['active_class']       = 'library';
        $data['layout']             = getLayout();
        $data['title']              = getPhrase('library_masters');
        $data['module_helper']      = getModuleHelper('masterasset-list');
    	return view('library.library-masters.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
        $records = LibraryMaster::select([   
         	'asset_type_id', 'image', 'title', 'author_id', 'publisher_id', 'total_assets_count', 'total_assets_available', 'total_assets_issued','edition','id','slug']);
       $this->setLibrarySettings();
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         

            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="'.URL_LIBRARY_COLLECTIONS.$records->slug.'"><i class="fa fa-paper-plane"></i>'.getPhrase("view").'</a></li>

                              
                           
                            <li><a href="'.URL_LIBRARY_MASTERS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>

                             <li><a href="'.URL_LIBRARY_ASSET_DETAILS.$records->slug.'"><i class="fa fa-outdent" aria-hidden="true"></i>'.getPhrase("asset_details").'</a></li>
                            
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        ->editColumn('image', function($records){
            $path = IMAGE_PATH_UPLOAD_LIBRARY_DEFAULT_THUMB;
            if($records->image)
            {
                $path = IMAGE_PATH_UPLOAD_LIBRARY_THUMB.$records->image;
            }

            return '<a href="'.URL_LIBRARY_COLLECTIONS.$records->slug.'"><img src="'.$path.'" height="100" width="100" /></a>';
        })

        ->editColumn('title', function ($records) {
            return '<a href="'.URL_LIBRARY_COLLECTIONS.$records->slug.'">'.$records->title.'</a>';
        })
        ->editColumn('asset_type_id', function ($records) {
            return $records->assetType->asset_type;
        })
        ->editColumn('author_id', function ($records) {
            return $records->author->author;
        })
        ->editColumn('publisher_id', function ($records) {
            return $records->publisher->publisher;
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
          if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $data['record']             = FALSE;
        $data['asset_types']        = array_pluck(LibraryAssetType::all(), 'asset_type', 'id');
        $data['authors']            = array_pluck(App\Author::all(), 'author', 'id');
        $data['publishers']         = array_pluck(App\Publisher::all(), 'publisher', 'id');
        
        $data['active_class']       = 'library';
        $data['layout']             = getLayout();
    	  $data['title']                = getPhrase('create_master_asset');
        $data['module_helper']      = getModuleHelper('masterasset-create');
    	return view('library.library-masters.add-edit', $data);
    }
       
       /**
        * This Method Will Dispaly The Complete MasterAsset Details 
        * Status Of Details 
        * @param  [type] $slug [description]
        * @return [type]       [description]
        */
     public function master_assetDetails($slug)
     { 
        if(!checkRole(getUserGrade(8)))
        {
          prepareBlockUserMessage();
          return back();
        }
       $asset_data        = LibraryMaster::where('slug','=',$slug)->get()->first();
       $master_asset_name = LibraryAssetType::where('id','=',$asset_data->asset_type_id)->get()->first();
       $publisher_name    = Publisher::where('id','=',$asset_data->publisher_id)->get()->first();
       $author_name       = Author::where('id','=',$asset_data->author_id)->get()->first();
       
        $data['active_class']       = 'library';
        $data['asset_data']         = $asset_data;
        $data['master_asset_name']  = $master_asset_name;
        $data['publisher_name']     = $publisher_name;
        $data['author_name']        = $author_name;
        $data['layout']             = getLayout();
        $data['title']              = getPhrase('master_asset_details');

            return view('library.library-masters.details', $data);
       }

      public function printMasterAssetDetails($slug)
      {
           $asset_data        = LibraryMaster::where('slug','=',$slug)->get()->first();
       $master_asset_name = LibraryAssetType::where('id','=',$asset_data->asset_type_id)->get()->first();
       $publisher_name    = Publisher::where('id','=',$asset_data->publisher_id)->get()->first();
       $author_name       = Author::where('id','=',$asset_data->author_id)->get()->first();
       
        $data['active_class']       = 'library';
        $data['asset_data']         = $asset_data;
        $data['master_asset_name']  = $master_asset_name;
        $data['publisher_name']     = $publisher_name;
        $data['author_name']        = $author_name;
        $data['layout']             = getLayout();
        $data['title']              = getPhrase('master_asset_details');

        $view     = \View::make('library.library-masters.print-file-details',$data);
        $contents = $view->render();

        return $contents;
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
    	$record = LibraryMaster::getRecordWithSlug($slug);
 
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;

    	 $data['asset_types']        = array_pluck(LibraryAssetType::all(), 'asset_type', 'id');
        $data['authors']            = array_pluck(App\Author::all(), 'author', 'id');
        $data['publishers']         = array_pluck(App\Publisher::all(), 'publisher', 'id');
        $data['active_class']       = 'library';
    	$data['title']              = getPhrase('edit_master_asset');
        $data['layout']             = getLayout();
    	return view('library.library-masters.add-edit', $data);
    }

  
    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
          if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$record = LibraryMaster::getRecordWithSlug($slug);
		$rules = [
         'asset_type_id'              => 'bail|required' ,
         'title'                      => 'bail|required|max:60' ,
        'author_id'                  => 'bail|required' ,
         'publisher_id'               => 'bail|required' ,
         'actual_price'               => 'bail|required|numeric' ,
         'chargible_price_if_lost'    => 'bail|required|numeric' ,
            ];
      
       $asset_belongs_to_subject    = $request->asset_belongs_to_subject;

       if($asset_belongs_to_subject)
       {
            $rules['subject_id']        = 'bail|required|integer';
       }

       //Validate the overall request
       $this->validate($request, $rules);
        $name                      = $request->title;
        if($name != $record->title)
          $record->slug               = $record->makeSlug($name);  
         
        $record->title             = $name;
        
        $record->asset_type_id      = $request->asset_type_id;
        $record->author_id          = $request->author_id;
        $record->publisher_id       = $request->publisher_id;
        $record->actual_price       = $request->actual_price;
        $record->chargible_price_if_lost = $request->chargible_price_if_lost;
        $record->description        = $request->description;
        $record->isbn               = $request->isbn;
        $record->edition            = $request->edition;
        $record->record_updated_by  = Auth::user()->id;

        $record->save();
        $file_name = 'image';
        if ($request->hasFile($file_name))
        {

             $rules = array( $file_name => 'mimes:jpeg,jpg,png,gif|max:10000' );
              $this->validate($request, $rules);
              /**
               * Delete the old file
               * upload the new file
               */

            $librarySettings = (object) json_decode((new LibrarySettings())->getSettings());
            if(!env('DEMO_MODE')) {
            $this->deleteFile($record->image, $librarySettings->libraryImagepath);
            $this->deleteFile($record->image, $librarySettings->libraryImageThumbnailpath);
            $record->image      = $this->processUpload($request, $record,$file_name);
          }
            $record->save();
        }

        flash('success','record_updated_successfully', 'success');
        return redirect('library/master');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
          if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
	    ////////////////////////////////////////////////////
    	// Split the validation rules as per the request  //
	    ////////////////////////////////////////////////////
    	$rules = 
        [
         'asset_type_id'              => 'bail|required' ,
         'title'                      => 'bail|required|max:60' ,
         'author_id'                  => 'bail|required' ,
         'publisher_id'               => 'bail|',
         'actual_price'               => 'bail|required|numeric' ,
         'chargible_price_if_lost'    => 'bail|required|numeric' ,
         ];
      
       $asset_belongs_to_subject    = $request->asset_belongs_to_subject;

       	$total_assets_available 	= 0;
   		$total_assets_damaged 		= 0;
   		$total_assets_lost 			= 0;
      
       if($asset_belongs_to_subject)
       {
            $rules['subject_id']        = 'bail|required|integer';
       }

       //Validate the overall request
       $this->validate($request, $rules);

      
    	$record 					= new LibraryMaster();
        $name 		  		  		= $request->title;
        $record->title 		       = $name;
        $record->slug 			    = $record->makeSlug($name);
        $record->asset_type_id      = $request->asset_type_id;
        $record->author_id          = $request->author_id;
        $record->publisher_id       = $request->publisher_id;
        $record->actual_price       = $request->actual_price;
        $record->chargible_price_if_lost = $request->chargible_price_if_lost;
        
        $record->total_assets_available = $total_assets_available;	
        $record->total_assets_lost  = $total_assets_lost;   
        $record->total_assets_damaged  = $total_assets_damaged;	
        $record->description        = $request->description;
        $record->isbn               = $request->isbn;
        $record->edition            = $request->edition;
        $record->record_updated_by 	= Auth::user()->id;
        $record->save();
        $file_name = 'image';
        if ($request->hasFile($file_name))
        {

             $rules = array( $file_name => 'mimes:jpeg,jpg,png,gif|max:10000' );
              $this->validate($request, $rules);
              $record->image      = $this->processUpload($request, $record,$file_name);
              $record->save();
        }

        flash('success','record_added_successfully', 'success');
    	return redirect('library/master');
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
       $record =  LibraryMaster::where('slug', $slug)->first();

       $librarySettings = (object) json_decode((new LibrarySettings())->getSettings());
        try{
          $count = App\LibraryIssue::isAssetOnIssue($record->id);
          if($count==0){
        if(!env('DEMO_MODE')) {
          $record->delete();
           $this->deleteFile($record->image, $librarySettings->libraryImagepath);
           $this->deleteFile($record->image, $librarySettings->libraryImageThumbnailpath);
        }

            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
          }
          else {
            $response['status'] = 0;
            $response['message'] = $count.' '.getPhrase('assets_on_issue');
          }
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

    public function deleteFile($record, $path, $is_array = FALSE)
    {
      if(env('DEMO_MODE')) {
        return;
      }
          
      if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $files = array();
       $has_files = FALSE;
       if($is_array) {
           foreach($record as $option) {
                if($option->has_file) {
                    $has_files = TRUE;
                    $files[] = $path.$option->file_name;
                }
             }
        }
        else {
            $has_files = TRUE;
            $files[] = $path.$record;
        }

         if($has_files)
        {
          if(!env('DEMO_MODE')) {
             File::delete($files);
           }
        }
    }

     /**
     * This method process the image is being refferred
     * by getting the settings from ImageSettings Class
     * @param  Request $request   [Request object from user]
     * @param  [type]  $record    [The saved record which contains the ID]
     * @param  [type]  $file_name [The Name of the file which need to upload]
     * @return [type]             [description]
     */
     public function processUpload(Request $request, $record, $file_name)
     {
          if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }

      if(env('DEMO_MODE')) {
        return;
      }
         if ($request->hasFile($file_name)) {
          $librarySettings = (object) json_decode((new App\LibrarySettings())->getSettings());
          
          $destinationPath      = $librarySettings->libraryImagepath;
          $thumbnail            = $librarySettings->libraryImageThumbnailpath;
          $fileName = $record->id.'-'.$file_name.'.'.$request->$file_name->guessClientExtension();
          
          $request->file($file_name)->move($destinationPath, $fileName);
         
         //Save Normal Image with 300x300
          Image::make($destinationPath.$fileName)->fit($librarySettings->imageSize)->save($destinationPath.$fileName);
         //Save thumb Image with 150x150
          Image::make($destinationPath.$fileName)->fit($librarySettings->thumbnailSize)->save($thumbnail.$fileName);
        
         return $fileName;
        }
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
    	return '/library/master';
    }

    /**
     * Displays the list of instance records based on master record slug
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function viewCollections($slug)
    {
      if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $record = LibraryMaster::getRecordWithSlug($slug);

        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

         $records = LibraryInstance::where('library_master_id','=',$record->id)
       ->select(['asset_no','asset_type', 'status',  'id'])->get()->first();

        $data['master_record']      = $record;
        $data['records']            = $records;
        
        $data['active_class']       = 'library';
        $data['layout']             = getLayout();

        $data['title']              = getPhrase('collections');


        if(count($records))
        $data['title']              = ucfirst($record->title).' '.getPhrase('collections');
        $data['module_helper']      = getModuleHelper('masterasset-collections-list');
      
        return view('library.library-masters.collections.instance-list', $data);                
    }


     /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getInstanceDatatable($slug)
    {
        $master_record = LibraryMaster::getRecordWithSlug($slug);
       $records = LibraryInstance::where('library_master_id','=',$master_record->id)
       ->select(['asset_no','asset_type', 'status',  'id']);
       
       $this->setLibrarySettings();

        return Datatables::of($records)
        ->addColumn('action', function ($records) {

            $button_text = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                       
                            
                            <li><a href="'.URL_LIBRARY_COLLECTIONS_BARCODE.$records->asset_no.'" target="_blank"><i class="fa fa-barcode"></i>'.getPhrase("barcode").'</a></li>';

                         if($records->status=='available'){

                         $button_text.=' <li><a href="javascript:void(0);" onclick="changeStatus(\''.$records->id.'\',\'damaged\');" ><i class="fa fa-chain-broken" aria-hidden="true"></i>'.getPhrase('damaged').'</a></li>';

                          $button_text.=' <li><a href="javascript:void(0);" onclick="changeStatus(\''.$records->id.'\',\'lost\');" ><i class="fa fa-minus-square" aria-hidden="true"></i>'.getPhrase('lost').'</a></li>';

                         }   
                            
                
                if(checkRole(getUserGrade(1)) && $records->status!='issued' ) {
                  $button_text .= '<li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->id.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                    }

                        $button_text .='</ul>
                    </div>';
                    return $button_text;
            })
        
       
        ->editColumn('asset_type', function ($records) {
            return ucfirst($records->asset_type);
        })
        ->editColumn('status', function ($records) {
            $class = "class = 'label label-success'";
            if($records->status == 'lost')
                $class = "class = 'label label-danger'";
            if($records->status == 'damaged')
                $class = "class = 'label label-default'";
             if($records->status == 'issued')
                $class = "class = 'label label-info'";

            return 
            '<span '.$class.' >'.ucfirst($records->status).'</span>';
        })
        ->removeColumn('id')
        // ->removeColumn('status')
        ->make();
    }

    public function statusChange(Request $request)
    {
       // dd($request);
      $record =   LibraryInstance::where('id','=',$request->asset_no)->get()->first();
    
      $record->status = $request->current_status;

      $record->save();
       
        (new App\LibraryInstance())->updateInstanceRecord($request->asset_no, $request->current_status);

       flash('success','status_changed_successfully', 'success');
          return back();
    }
   


    public function addCollection($slug)
    {
          if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
         $record = LibraryMaster::getRecordWithSlug($slug);
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);
        $data['master_record']      = $record;
        $data['record']             = FALSE;
        $data['active_class']       = 'library';
        $data['layout']             = getLayout();
        $data['library_masters']    = array_pluck(App\LibraryMaster::all(), 'title');
        $data['title']              = getPhrase('generate_collection').' '.$record->title;
        $data['module_helper']      = getModuleHelper('collections-create');
        return view('library.library-masters.collections.add-edit', $data);
    }

    public function storeCollection(Request $request, $slug)
    {
        $record = LibraryMaster::getRecordWithSlug($slug);
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $rules = [
         'from'              => 'bail|required|integer' ,
         'to'                => 'bail|required|integer' ,
         'series_prefix'     => 'bail|required|max:15' ,
          ];

       //Validate the overall request
       $this->validate($request, $rules);
        
        $librarySettings  = getLibrarySettings();
        $from             = $request->from;
        $to               = $request->to;
        $series_prefix    = $request->series_prefix;
        $library_prefix   = getSetting('library_series_prefix','library_settings');
        $length           = getSetting('library_series_number_length','library_settings');
        $master_id        = $record->id;
        $asset_type       = $request->asset_type;
        $record_updated_by = Auth::user()->id;

        $collectionData = array();

          DB::beginTransaction();

      try
      {
        for($num = $from; $num <= $to; $num++) {
            $tempData = array();
            $sno = $num;
            $sno = makeNumber($sno, $length);//str_pad($sno, $length, '0', STR_PAD_LEFT);
            $asset_no = $library_prefix.$series_prefix.$sno;
            $tempData = array(
                                'asset_no'          => $asset_no,
                                'library_prefix'    => $library_prefix,
                                'series_prefix'     => $series_prefix,
                                'number'            => $num,
                                'library_master_id' => $master_id,
                                'asset_type'        => $asset_type,
                                'status'            => 'available',
                                'record_updated_by' => $record_updated_by,
                                );
            array_push($collectionData, $tempData);
        }
        
        LibraryInstance::insert($collectionData);
        $record->updateCount($record->id);
        DB::commit();
        flash('success','record_added_successfully', 'success');
         }
     catch(Exception $e)
     {

      DB::rollBack();
      
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->getMessage(), 'error');
       }
       else {
        flash('oops...!','the_same_prefix_is_already_available', 'overlay');
       }
     }


       return redirect('library/master/collections/'.$record->slug);
    }

    public function editCollection($slug)
    {
          if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }

           $record = LibraryMaster::getRecordWithSlug($slug);
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);
        $data['master_record']      = $record;
        $data['record']             = $record;
        $data['active_class']       = 'library';
        $data['layout']             = getLayout();
        $data['library_masters']    = array_pluck(App\LibraryMaster::all(), 'title');
        $data['title']              = getPhrase('edit_collection').' '.$record->title;
        return view('library.library-masters.collections.add-edit', $data);


    }

    public function updateCollection(Request $request ,$slug)
    {

    }

    public function generateBarCode($asset_no)
    {
        
        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($asset_no, "C39") . '" alt="barcode"   />';
    }

    public function deleteRecord($id)
    {
      if(!checkRole(getUserGrade(8)))
      {
        prepareBlockUserMessage();
        return back();
      }
        /**
       * 
       * Delete the book which status is available
       * @var [type]
       */
        $record = LibraryInstance::where('id','=', $id)->first();
        try{
          if(!env('DEMO_MODE')) {
            $record->delete();
          }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
        }
         catch ( \Illuminate\Database\QueryException $e) {
                 $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
       }
        return json_encode($response);


         }
}
