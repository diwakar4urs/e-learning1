<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class LibraryIssue extends Model
{
    protected $table = "libraryissues";

    public function getCurrentIssuedRecords($user_id)
    {
    	$recs = LibraryIssue::	where('user_id', '=', $user_id)
    							->where('issue_type', '=', 'issue')
    							->orWhere('issue_type', '=', 'renew')->get();
    	return $recs;
    }

    public function masterData()
    {
    	return $this->belongsTo('App\LibraryMaster', 'library_master_id');
    }

    public function instanceData()
    {
    	return $this->belongsTo('App\LibraryInstance', 'library_instance_id');
    }
    /**
       * This method returns the role_id when we are giving the user_type vice versa
       * @param  string $user_type [description]
       * @return [type]            [description]
       */
    public function getIssuesCount($user_type = 'student')
    {
       $role_id = getRoleData($user_type);
       $count   = LibraryIssue::join('users','libraryissues.user_id','=','users.id')       ->where('role_id','=',$role_id)
                  ->where('issue_type','=','issue') 
                  ->get()->count();

       return $count;
    }
    /**
     * This method returns the role_id when we are giving the user_type vice versa
     * [getIssuesStaffCount description]
     * @param  string $user_type [description]
     * @return [type]            [description]
     */
     public function getIssuesStaffCount($user_type = 'staff')
    {
       $role_id = getRoleData($user_type);
       $count   = LibraryIssue::join('users','libraryissues.user_id','=','users.id')       ->where('role_id','=',$role_id)
                  ->where('issue_type','=','issue')
                  ->get()->count();
       
       return $count;
    }

    public function isUserHavingBookings($user_id)
    {
      return LibraryIssue::where('user_id','=',$user_id)
                              ->where('issue_type', '=', 'issue')
                              ->orWhere('issue_type', '=', 'renewal')
                              ->count();
    }


    public static function isAssetOnIssue($asset_master_id)
    {
      return LibraryIssue::where('master_asset_id','=',$asset_master_id)
                              ->where('issue_type', '=', 'issue')
                              ->orWhere('issue_type', '=', 'renewal')
                              ->count();
    }

    /**
     * This method will return the latest limited no. of
     * records as library history
     * @param  integer $user_id [description]
     * @param  integer $limit   [description]
     * @return [type]           [description]
     */
    public static function issueHistory($user_id=0, $limit=5)
    {
      if(!$user_id)
        $user_id = Auth::user()->id;

      return LibraryIssue::join('librarymasters', 'librarymasters.id', '=', 'libraryissues.master_asset_id')
                          ->where('user_id','=',$user_id)
                          ->orderBy('updated_at','desc')
                          ->select(['title','library_asset_no','issued_on','issue_type','libraryissues.updated_at'])
                          ->limit($limit)
                          ->get();
    }


}
