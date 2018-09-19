<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Department;
use Yajra\Datatables\Datatables;
use DB;
class DepartmentsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Departments listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $data['active_class']       = 'settings';
        $data['title']              = getPhrase('departments');
    	return view('departments.list-departments', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
        DB::statement(DB::raw('set @rownum=0'));

         $records = Department::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'department_name', 'department_code','slug','description']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/departments/edit-department/'.$records->slug.'"><i class="icon-packages"></i>'.getPhrase("edit").'</a></li>
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="icon-packages"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function createDepartment()
    {
    	$data['department']         = FALSE;
    	$data['active_class']       = 'settings';
        $data['title']              = getPhrase('create_department');
    	return view('departments.add-edit-department', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function editDepartment($slug)
    {
    	$department = Department::where('slug', $slug)->get()->first();
    	$data['department']       	= $department;
    	$data['active_class']       = 'settings';
        $data['title']              = getPhrase('edit_department');
    	return view('departments.add-edit-department', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function updateDepartment(Request $request, $slug)
    {

        $department                 = Department::where('slug', $slug)->get()->first();
        
            $this->validate($request, [
            'department_name'          => 'bail|required|max:20',
            'department_code'          => 'bail|required|unique:departments,department_code,'.$department->id.'|max:10',
            ]);

        $name                       = $request->department_name;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $department->department_name)
            $department->slug = $department->makeSlug($name);
    	
        $department->department_name = $name;
        $department->department_code = $request->department_code;
    	$department->description 	= $request->description;
    	$department->save();
    	flash('success','record_updated_successfully', 'success');
    	return redirect('departments');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function storeDepartment(Request $request)
    {
    	$this->validate($request, [
        'department_name'          => 'bail|required|max:20',
        'department_code'          => 'bail|required|unique:departments|max:10',
        ]);
    	$department = new Department();
        $name 						= $request->department_name;
        $department->department_name = $name;
        $department->department_code = $request->department_code;
        $department->description 	= $request->description;
        $department->slug 			= $department->makeSlug($name);
       
        $department->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('departments');
    }

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        Department::where('slug', $slug)->delete();
        return 1;
    }

}
