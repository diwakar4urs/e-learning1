<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibraryAssetType extends Model
{
	protected $table = 'libraryassettypes';

    public static function getRecordWithSlug($slug)
    {
        return LibraryAssetType::where('slug', '=', $slug)->first();
    }
}
