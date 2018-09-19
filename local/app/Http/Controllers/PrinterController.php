<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use Anam\PhantomMagick\Converter;
use Exception;

class PrinterController extends Controller
{
     
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function printHtml(Request $request)
    {
    	$htmldata = $request->html_data;
    	$conv = new Converter();
        $conv->addPage($htmldata.'<p style="text-align: right;"> Printed on '.date('Y-m-d').'</p>');
        

        $options = [
                      'format' => 'A4',
                      'zoomfactor' => 0.5,
                      'orientation' => 'Landscape',
                      'margin' => '1 cm'
                    ];
          try{
        $conv->setPdfOptions($options);
        $conv->download('download.pdf',1);
          }
    	catch(Exception $e)
        {
          flash('Oops..!','encountered_an_error_with_message'.'  \n'.$e->getMessage(). PDF_EXCEPTION_MENORAH_MESSAGE, 'overlay');     
          return back();
        }
    }
}
