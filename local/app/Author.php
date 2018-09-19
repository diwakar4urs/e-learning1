<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
   protected $table="authors";
    
    public static function getRecordWithSlug($slug)
    {
        return Author::where('slug', '=', $slug)->first();
    }
}
