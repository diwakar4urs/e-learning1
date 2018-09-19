<?php
namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use App\Http\Requests;

use Yajra\Datatables\Datatables;
use DB;
use \Auth;
use App\Academic;
use App\Course;
use App\Timingset;
use App\TimeingSetMap;
use App\ParentTimingSetMap;

class MapTimingsetController extends Controller
{
      public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
   

    public function create($slug)
    {
         if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

           $record = App\ParentTimingSetMap::where('slug','=',$slug)->first();
           dd($record);
           if($isValid = $this->isValidRecord($record))
           return redirect($isValid);

      $data['record']           = $record;
      $data['active_class']     = 'academic';
     
      $data['academic_years']   = addSelectToList(\App\Academic::pluck('academic_year_title', 'id'));
      $data['timingsets']       = addSelectToList(\App\Timingset::pluck('name', 'id'));
      dd($data['timingsets']);
      $data['parentmap_data']   = App\ParentTimingSetMap::where('slug','=',$slug)
      ->select('id')->first();
      $data['items']            = json_encode(
                                   array(
                                         'academic_years'=>\App\Academic::select(['id', 'academic_year_title'])->get()
                                     ) );
      
      $data['title']            = getPhrase('map_timetable');
      $data['days']             = getDay($dayNumber=-1);
      $data['layout']           = getLayout();
      
      return view('maptimetable.form_elements', $data);
    }

    public function store(Request $request ,$slug)
    {
     $count=$request->academic_id;
     
       if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
        
          $record = App\ParentTimingSetMap::where('slug','=',$slug)->first();

           if($isValid = $this->isValidRecord($record))
           return redirect($isValid);

            $model = TimeingSetMap::where('parenttimingsetmap_id','=',$record->id);
           
            $count = $model->count();
        
         $parenttimingsetmap_id = $record->id;
            DB::beginTransaction();
          try{
                 if($count)
               {
            //Previous records exists  
            $model->delete();
                    }

          $timeset_data             = $request->timeset;

          foreach ($timeset_data as $key => $value) {
          $record                         = new App\TimeingSetMap();  
          $record->timingset_id           = $value; 
          $record->day                    = $key; 
          $record->academic_id            = $request->academic_id; 
          $record->parenttimingsetmap_id  = $parenttimingsetmap_id; 
          $record->course_parent_id       = $request->course_parent_id; 
          $record->course_id              = $request->course_id; 

          $record->save();
          $year_data                = $request->selected_list;
            foreach ($year_data as $list) {
                 $parameters = explode('_',$list);

             $year_record    =  App\TimeingSetMap::where('timingset_id','=',$record->timingset_id)
             ->where('day','=',$record->day)
             ->where('academic_id','=',$record->academic_id)
             ->where('course_parent_id','=',$record->course_parent_id)
             ->where('course_id','=',$record->course_id)
             ->where('parenttimingsetmap_id','=',$record->parenttimingsetmap_id)

            ->first();


             
             $year_record->year    = $parameters[3];

             $year_record->save();
            
            }
          
       
          }
             DB::commit();
            flash('success...!','records_updated_successfully', 'success');
        }
        catch(Exception $ex)
        {
         
         DB::rollBack();

         if(getSetting('show_foreign_key_constraint','module'))
          {

          flash('oops...!',$e->getMessage(), 'error');
       }
       else {
          flash('oops...!','improper_data', 'error');
       }

      }

       return redirect(URL_MAP_TIMINGSET_PARENT);

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
      return URL_MAP_TIMINGSET_PARENT;
    }

}