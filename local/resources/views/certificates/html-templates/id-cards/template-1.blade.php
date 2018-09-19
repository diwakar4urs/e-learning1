<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body style="margin: 0;">
@foreach($users_list as $user)
    <table cellpadding="10" width="740" cellspacing="0" border="0" align="center">
        <tr>
            <td width="50%" valign="top">
                <div style="border:1px solid #aaa; border-radius: 10px; padding:15px; min-height: 470px;">
                    <table cellpadding="0" width="100%" cellspacing="0" border="0" style="font-family: sans-serif;  font-size: 14px; color: #999; line-height:24px;">
                        <tr>
                            <td align="center" style="padding: 5px 10px; ">
                                <img src="{{IMAGE_PATH_SETTINGS.getSetting('template_1_logo', 'id_card_settings')}}" height="50" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 5px 10px; ">
                                <h1 style="font-size: 24px; margin: 0;color: #0870b6;">{{getSetting('institute_title','id_card_settings')}}</h1>
                                
                                <p style="margin: 0;"><strong>{{getSetting('institute_address','id_card_settings')}}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <img src="{{getProfilePath($user->image,'profile')}}" width="120" alt="">
                                <h2 style="font-size: 18px; margin: 0;color: #020230;">{{$user->name}}</h2>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                         <?php  $certificateObject = new App\Certificate();
                                $current_item_number = 1;
                                $max_items = getSetting('front_total_fields','id_card_fields');
                         ?>

                            <td style="padding:0 10px;">
                                <table cellpadding="0" width="100%" cellspacing="0" border="0" style="font-family: sans-serif;  font-size: 12px; color: #999; line-height:18px;">
                                     <?php $item = $certificateObject->getIdCardData('front_first_item', $user); ?>
                            
                                    <tr>
                                    @if($item)
                                        @if($current_item_number++ <= $max_items)
                                        <td width="50%" style="padding:3px"><span style="color: darkslategrey;"> 
                                        {{$certificateObject->getIdCardData('front_first_item_title')}} &nbsp;:</span> <strong> {{$item}}</strong></td>
                                        @endif
                                    @endif
                                    </tr>
                                     <?php $item = $certificateObject->getIdCardData('front_second_item', $user);
                            ?>
                            <tr>
                            @if($item)

                                @if($current_item_number++ <=$max_items)
                                        <td width="50%" style="padding:3px"><span style="color: darkslategrey;">{{$certificateObject->getIdCardData('front_second_item_title')}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span> <strong> {{$item}}</strong></td>
                                @endif
                            @endif
                                    </tr>
                                
                                    <tr>
                                        <?php $item = $certificateObject->getIdCardData('front_third_item', $user);
                            ?>
                            @if($item)
                                @if($current_item_number++ <=$max_items)
                                        <td width="50%" style="padding:3px"><span style="color: darkslategrey;">{{$certificateObject->getIdCardData('front_third_item_title')}} &nbsp;:</span> <strong> {{$item}}</strong></td>
                                @endif
                            @endif
                            </tr>
                              <?php $item = $certificateObject->getIdCardData('front_fourth_item', $user);
                            ?>
                            <tr>
                            @if($item)

                                @if($current_item_number++ <=$max_items)
                                        <td width="50%" style="padding:3px"><span style="color: darkslategrey;">{{$certificateObject->getIdCardData('front_fourth_item_title')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span><strong> {{$item}}</strong></td>
                                @endif
                            @endif
                                    </tr>
                                    <tr>
                                     <?php $item = $certificateObject->getIdCardData('front_fifth_item', $user);
                            ?>
                            @if($item)

                                @if($current_item_number++ <=$max_items)
                                        <td colspan="2" width="100%" style="padding:3px">
                                            <table cellpadding="0" width="100%" cellspacing="0" border="0">
                                                <tr>
                                                    <td valign="top"><span style="color: darkslategrey;">{{$certificateObject->getIdCardData('front_fifth_item_title')}} :</span>
                                                    <strong> {{$item}}</strong></td>
                                                </tr>
                                            </table>
                                        </td>
                                @endif
                            @endif
                                    </tr>
                                    <tr>
                                         <?php $item = $certificateObject->getIdCardData('front_sixth_item', $user);
                            ?>
                        @if($item)
                            @if($current_item_number++ <=$max_items)
                                        <td width="50%" style="padding:3px"><span style="color: darkslategrey;">{{$certificateObject->getIdCardData('front_sixth_item_title')}} :</span> <strong> {{$item}}</strong></td>
                            @endif
                        @endif
                         <?php $item = $certificateObject->getIdCardData('front_seventh_item', $user);
                            ?>
                        @if($item)
                            @if($current_item_number++ <=$max_items)

                                        <td width="50%" style="padding:3px"><span style="color: darkslategrey;">{{$certificateObject->getIdCardData('front_seventh_item_title')}} :</span> <strong> {{$item}}</strong></td>
                            @endif
                        @endif
                                    </tr>
                                    <tr>
                                       <td align="right"><img src="{{IMAGE_PATH_SETTINGS.getSetting('right_sign_image','certificate')}}" width="80" alt="">

                        <br/><b style="font-size:16px;">Principal</b>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
           
            <td width="50%" valign="top">
                <div style="border:1px solid #aaa; border-radius: 10px; 
                padding:15px; min-height: 470px;">
                    <table 
                    cellpadding="0" width="100%" 
                    cellspacing="0" border="0" 
                    style="font-family: sans-serif;  
                    font-size: 14px; color: #999; 
                    line-height:24px;margin-bottom: 140px;">
                        <tr>
                            <td align="center" style="padding: 5px 10px; ">
                               <img src="{{IMAGE_PATH_SETTINGS.getSetting('template_1_logo', 'id_card_settings')}}" height="50" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="padding:0 10px;">
                                <table cellpadding="0" width="100%" cellspacing="0" border="0" style="font-family: sans-serif;  font-size: 14px; color: #999; line-height:18px;">

                                    <tr>
                                        <td>
                                            <p style="color: darkslategrey; margin-bottom:0;">
                                            <strong>{{getSetting('back_first_item_title', 'id_card_fields')}}</strong></p>
                                            {{getSetting('back_first_item_text', 'id_card_fields')}}
                                            </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <p style="color: darkslategrey; margin-bottom:0;"><strong>{{getSetting('back_second_item_title', 'id_card_fields')}}</strong></p> {!!getSetting('back_second_item_text', 'id_card_fields')!!}</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p style="color: darkslategrey; margin-bottom:0;"><strong>{{getSetting('back_third_item_title', 'id_card_fields')}}</strong></p>{!!getSetting('back_third_item_text', 'id_card_fields')!!}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="color: darkslategrey; margin-bottom:0;"><strong>{{getSetting('back_fourth_item_title', 'id_card_fields')}}</strong></p>{!!getSetting('back_fourth_item_text', 'id_card_fields')!!}</td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            
        </tr>
 
    </table>
    @endforeach
</body>

</html>