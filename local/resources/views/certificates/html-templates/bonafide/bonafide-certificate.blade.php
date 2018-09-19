<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bonafide Certificate</title>
    <style>
        {font-family: sans-serif;font-size: 16px;color: #333;margin-bottom: 0; text-transform: uppercase}
        {padding: 5px 10px; text-align: left; margin: 0;}
    </style>
</head>
<body style="margin: 0;">
@if(getSetting('show_watermark', 'bonafide_settings')) 
<div style="background-image: url({{IMAGE_PATH_SETTINGS.getSetting('watermark_image', 'bonafide_content')}}); background-repeat: none; background-size: 80% auto; background-position: center center; ">
@else
<div>
@endif
 
<table cellpadding="0" width="100%" cellspacing="0" border="0" style="font-family: sans-serif;  font-size: 14px; color: #999; line-height:24px;">
   
    <tr class="">
        <td>
        @if(getSetting('print_header', 'bonafide_settings')) 
            <table cellpadding="0" width="100%" cellspacing="0" border="0">
                <tr>
                    <td width="20%" style="padding: 5px 10px; text-align: left; font-size:16px;">
                    @if(getSetting('print_reference_number', 'bonafide_settings')) 
                    {{getPhrase('reference_no')}}: <strong style="color:#f00">{{$reference_no}}</strong>
                    @endif
                    
                    </td>
                    <td style="padding: 5px 10px; text-align: center;">
                        <table cellpadding="0" width="100%" cellspacing="0" border="0">

                            <tr>
                                <td align="center">
                                    <img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" width="250" alt="">
                                </td>
                            </tr>
                             <tr>
                                <td align="center">
                                    
                                    <h4 style="font-size: 20px; margin:5px 0 20px 0;color: #333;"> Bonafide Certificate
                                    </h4>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                    <td width="20%" style="padding: 5px 10px; text-align: right; font-size:16px;">
                    @if(getSetting('print_date', 'bonafide_settings')) 
                      Date: <strong style="color:#000;">{{date('Y/m/d')}}</strong> 
                    @endif
                    
                    </td>
                </tr>
            </table>
            @endif
        </td>
    </tr>


    <tr>
        <td align="center">
            <hr>
        </td>
    </tr>


    <tr>
        {!! $content !!}
    </tr>
     
    @if(getSetting('print_footer', 'bonafide_settings')) 
    <tr>
        <td align="right" style="padding: 5px 10px;  font-size:16px;">
      @if(getSetting('right_sign_image', 'bonafide_settings')) 
        <div style=" text-align:right; margin:10px 0 0 ; color:#333; font-size:20px;">
        <img src="{{IMAGE_PATH_SETTINGS.getSetting('right_side_sign', 'bonafide_content')}}" height="40" alt="">
        </div>
       @endif
        @if(getSetting('right_side_name', 'bonafide_settings')) 
            <div style=" text-align:right; color:#333; font-size:15px;">
            <strong>{{getSetting('right_side_name', 'bonafide_content')}}</strong>
            </div>
        @endif
        @if(getSetting('right_side_designation', 'bonafide_settings')) 
               <div style=" text-align:right; margin:5px 0 0 ; color:#333; font-size:13px;"><strong>{{getSetting('right_designation', 'bonafide_content')}}</strong></div>
        @endif
            
        </td>
    </tr>
   @endif
</table>
</div>
</body>
 
</html>