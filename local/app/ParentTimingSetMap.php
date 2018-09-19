<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentTimingSetMap extends Model
{
    protected $table = 'parenttimingsetmap';


    public static function getRecordWithSlug($slug)
    {
        return ParentTimingSetMap::where('slug', '=', $slug)->first();
    }
    
    
}
