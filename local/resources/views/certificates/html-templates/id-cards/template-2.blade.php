<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <style>
        {
            border: 1px solid #555;
            padding: 10px;
            border-bottom: 1px solid #555;
            margin: 0;
            font-family: arial;
            padding: 5px;
            background: #4ca8f5; color: #fff;
        }
    </style>
</head>

<body >
<div id="DivIdToPrint">
 @foreach($users_list as $user)
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="450" style="border: 1px solid #ddd; font-family: arial; color:#555;">
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ddd" align="center"> <img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" height="40" alt="">
                <p style="margin: 0; color:#777">{{getSetting('site_address','site_settings')}}</p>
            </td>
        </tr>
        <tr>
        <?php $certificateObject = new App\Certificate();
        $current_item_number = 1;
        $max_items = getSetting('front_total_fields','id_card_fields')
        ?>
            <td style="padding: 10px;" width="100%">
                <table cellpadding="0" cellspacing="0" border="0" style="">
               
                    <tr>
                        <td width="120px"> <img src="{{getProfilePath($user->image,'profile')}}" width="110px" alt=""> </td>
                        <td style="padding: 0 15px 0 15px;" valign="top">
                            <table cellpadding="0" cellspacing="0" border="0" style="">
                            
                            
                            <?php $item = $certificateObject->getIdCardData('front_first_item', $user); ?>
                            @if($item)
                                @if($current_item_number++ <= $max_items)
                                <tr>
                                    <td style="padding: 5px;">
                                    <strong>
                                    {{$certificateObject->getIdCardData('front_first_item_title')}}
                                    </strong>
                                    </td>
                                    <td style="padding: 5px;" width="1%">:</td>
                                    <td style="padding: 5px;">
                                    {{$item}}
                                    </td>

                                </tr>
                                @endif
                            @endif
                            <?php $item = $certificateObject->getIdCardData('front_second_item', $user);
                            ?>
                            @if($item)

                                @if($current_item_number++ <=$max_items)
                                <tr>
                                    <td style="padding: 5px;"><strong>{{$certificateObject->getIdCardData('front_second_item_title')}}</strong></td>
                                    <td style="padding: 5px;" width="1%">:</td>
                                    <td style="padding: 5px;">
                                    {{$item}}
                                    
                                    </td>
                                </tr>
                                @endif
                                @endif
                            <?php $item = $certificateObject->getIdCardData('front_third_item', $user);
                            ?>
                            @if($item)
                             @if($current_item_number++ <=$max_items)
                                <tr>
                                    <td style="padding: 5px;"><strong> {{$certificateObject->getIdCardData('front_third_item_title')}}</strong></td>
                                    <td style="padding: 5px;" width="1%">:</td>
                                    <td style="padding: 5px;"> 
                                    {{$item}}
                                    </td>
                                </tr>
                                @endif
                            @endif
                            <?php $item = $certificateObject->getIdCardData('front_fourth_item', $user);
                            ?>
                            @if($item)

                                @if($current_item_number++ <=$max_items)
                                <tr>
                                    <td style="padding: 5px;"><strong>{{$certificateObject->getIdCardData('front_fourth_item_title')}}</strong></td>
                                    <td style="padding: 5px;" width="1%">:</td>
                                    <td style="padding: 5px;">{{$item}}</td>
                                </tr>
                                @endif
                            @endif
                            <?php $item = $certificateObject->getIdCardData('front_fifth_item', $user);
                            ?>
                            @if($item)

                                @if($current_item_number++ <=$max_items)
                                <tr>
                                    <td style="padding: 5px;"><strong>{{$certificateObject->getIdCardData('front_fifth_item_title')}}</strong></td>
                                    <td style="padding: 5px;" width="1%">:</td>
                                    <td style="padding: 5px;">{{$item}}</td>
                                </tr>
                                @endif
                            @endif
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td style="background: #4ca8f5; color: #fff;">
                <table cellpadding="0" cellspacing="0" border="0" style="">
                    <tr>
                     <?php $item = $certificateObject->getIdCardData('front_sixth_item', $user);
                            ?>
                        @if($item)
                            @if($current_item_number++ <=$max_items)
                        <td valign="middile" height="30px" width="120px" align="center" style="background: #fff; color: #4ca8f5; border:1px solid #4ca8f5;"><strong>{{$item}}</strong></td>
                            @endif
                        @endif
                        <?php $item = $certificateObject->getIdCardData('front_seventh_item', $user);
                            ?>
                        @if($item)
                            @if($current_item_number++ <=$max_items)
                        <td  style="padding: 5px;">{{$certificateObject->getIdCardData('front_seventh_item_title')}} {{$item}}</td>
                            @endif
                        @endif
                    </tr>
                </table> 
            </td>
        </tr>
    </table>
    <br>
     @endforeach
     </div>
</body>

<script >
function printDiv() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>
</html>