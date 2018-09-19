<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
protected $table = 'certificatetemplates';

    public static function getRecordWithSlug($slug)
    {
        return CertificateTemplate::where('slug', '=', $slug)->first();
    }


    public function templatedata($template, $data ,$records)
    {   
        $template = CertificateTemplate::where('title', '=', $template)->first();
             
         $data['user_name']           = $records->name;
         $data['course_title']        = $records->course_title;
         $data['academic_year_title'] = $records->academic_year_title;
         $data['roll_no']             = $records->roll_no;
         $data['current_year']        = $records->current_year;
         $data['current_semister']    = $records->current_semister;
         $data['left_sign_name_image'] = IMAGE_PATH_SETTINGS.getSetting('left_sign_image', 'certificate');

         $data['left_sign_name']        = getSetting('left_sign_name', 'certificate');
         $data['left_sign_designation'] = getSetting('left_sign_designation', 'certificate');

         $data['right_sign_name_image'] = IMAGE_PATH_SETTINGS.getSetting('right_sign_image', 'certificate');

         $data['right_sign_name']        = getSetting('right_sign_name', 'certificate');

         $data['right_sign_designation'] = getSetting('right_sign_designation', 'certificate');

         $data['center_logo']            = IMAGE_PATH_SETTINGS.getSetting('bottom_middle_logo', 'certificate');

            $content = \Blade::compileString($this->getTemplate($template));
        
        $result = $this->render($content, $data);

        return $result;
    }


    /**
     * Returns the template html code by forming header, body and footer
     * @param  [type] $template [description]
     * @return [type]           [description]
     */
    public function getTemplate($template)
    {
       $view = \View::make('certificates.template', [
                                                'header' => '', 
                                                'footer' => '',
                                                'body'   => $template->content, 
                                                ]);

        return $view->render();
    }

    /**
     * Prepares the view from string passed along with data
     * @param  [type] $__php  [description]
     * @param  [type] $__data [description]
     * @return [type]         [description]
     */
    public function render($__php, $__data)
    {
        
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?' . '>' . $__php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }

    
}
