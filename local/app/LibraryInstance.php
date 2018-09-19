<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibraryInstance extends Model
{
    protected $table = "libraryassetinstances";

    public function masterRecord()
    {
    	return $this->belongsTo('App\LibraryMaster', 'library_master_id');
    }

    public function updateInstanceRecord($instance_id, $status)
    {
    	$instance = LibraryInstance::where('id','=',$instance_id)->first();
    	$instance->status = $status;
    	$instance->save();

    	(new LibraryMaster())->updateCount($instance->library_master_id);
    }
 
    
}
