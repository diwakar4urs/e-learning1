<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibraryMaster extends Model
{
   	protected $table = 'librarymasters';

  
    public static function getRecordWithSlug($slug)
    {
        return LibraryMaster::where('slug', '=', $slug)->first();
    }

    /**
     * This library item belongs to a asst type
     * @return [type] [description]
     */
    public function assetType()
    {
    	return $this->belongsTo('App\LibraryAssetType');
    }
    /**
     * This library item belongs to a author
     * @return [type] [description]
     */
    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    /**
     * This library item belongs to a publisher
     * @return [type] [description]
     */
    public function publisher()
    {
        return $this->belongsTo('App\Publisher');
    }

    public function collections()
    {
        return $this->hasMany('App\LibraryInstance');
    }
    
    public function updateCount($master_id)
    {
        $record = LibraryMaster::where('id','=',$master_id)->first();
        // return $record;
        $record->total_assets_count = $this->getCollectionsTotal($record->id);
        $record->total_assets_available = $this->getCollectionsTotalWithStatus($master_id, 'available');
        $record->total_assets_issued = $this->getCollectionsTotalWithStatus($master_id, 'issued');
        $record->total_assets_damaged = $this->getCollectionsTotalWithStatus($master_id, 'damaged');
        $record->total_assets_lost = $this->getCollectionsTotalWithStatus($master_id, 'lost');
        return $record->save();
    }

    public function getCollectionsTotal($master_id)
    {
        return LibraryMaster::find($master_id)->collections->count();
    }
    public function getCollectionsTotalWithStatus($master_id, $status='available')
    {
        return LibraryMaster::find($master_id)->collections()->where('status','=', $status)->get()->count();
    }
    
    public function getCollectionsTotalWithAssetType($master_id, $asset_type='general')
    {
        return LibraryMaster::find($master_id)->collections()->where('asset_type','=',$asset_type)->get()->count();
    }


    public static function getAssetsCount($value='')
    {
        $assets = LibraryAssetType::
                      select(['id','asset_type'])
                      ->get();
      
      
      $asset_names = [];
      $assets_count = [];
      foreach($assets as $asset)
      {
        $length = LibraryMaster::where('asset_type_id','=',$asset->id)
                                     ->sum('total_assets_count');

        array_push($assets_count, $length);
        array_push($asset_names, $asset->asset_type);


      }
      return array('names'=>$asset_names, 'count'=>$assets_count);
    }

}
