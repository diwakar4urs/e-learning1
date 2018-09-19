<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibrarySettings extends Model
{
    ////////////////////////////
    // Library upload options //
    ////////////////////////////
    
 
    protected $barcod_formats = array(
                                'PHARMA2T'  => 'PHARMA2T',
                                'C39'       => 'C39',
                                'C39+'      => 'C39+',
                                'QRCODE'    => 'QRCODE',
                                'DATAMATRIX'=> 'DATAMATRIX',
                                'EAN13'     => 'EAN13',
                                );
    protected $barcode_methods = array(
                                'getBarcodeSVG'      => 'getBarcodeSVG',
                                'getBarcodeHTML'     => 'getBarcodeHTML',
                                'getBarcodePNG'      => 'getBarcodePNG',
                                );

    protected  $settings = array(
     'libraryImagepath'     	=> "uploads/library/",
     'imageSize'                => 300,
     'thumbnailSize'            => 150,
     'examMaxFileSize'          => 10000,
     'libraryImageThumbnailpath' => "uploads/library/thumbnail/",
     'defaultImagePath'    		=> "uploads/library/default.png",
	 'defaultImageThumbnailpath' => "uploads/library/thumbnail/default.png",
     'prefix'                   => "ACALIB",
     'seriesNumberLength'       => 5,
     'maximum_issues_student'   =>2,
     'maximum_issues_staff'     =>4,
     'maximum_days_to_return_student' =>7,
     'maximum_days_to_return_staff' =>7,
     );


    protected $collection_types     = array(
                                            'general'   => 'General',
                                            'reference' => 'Reference',
                                            'staff'     => 'Staff',
                                            ); 

    /**
     * This method returns the settings related to Library System
     * @param  boolean $key [For specific setting ]
     * @return [json]       [description]
     */
    public function getSettings($key = FALSE)
    {
    	if($key && array_key_exists($key,$settings))
    		return json_encode($this->settings[$key]);
    	return json_encode($this->settings);
    }

    public function getCollectionTypes()
    {
        return $this->collection_types;
    }

    public function getBarcodeFormat()
    {
        return $this->barcod_formats['EAN13'];
    }
 
    public function getBarcodeMethod()
    {
        return $this->barcode_methods['getBarcodePNG'];
    }
}
