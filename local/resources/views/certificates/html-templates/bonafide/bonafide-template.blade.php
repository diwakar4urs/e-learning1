<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bonafide Certificate</title>
</head>

<body onload="printDiv()">
    <div id="DivIdToPrint" style="width:800px; height:600px; padding:20px; text-align:center;  box-sizing:border-box; border: 10px solid #787878; position:relative;">
        <img src="{{IMAGE_PATH_SETTINGS.getSetting('watermark_image', 'certificate')}}" style="position: absolute;right: 0;top: 0;" width="100%" alt="">
        <div style=" padding:60px 60px 30px; text-align:center; color:#333; line-height:26px; font-family:calibari; border: 5px solid #787878; box-sizing:border-box;position:relative;">
           
            <span style="position: absolute;right: 15px;top: 15px; text-align:left; font-family:arial; color:#777">{{getPhrase('date')}}: 
             
              <b>{{date('d M Y')}}</b>
              </span>
           <span ><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" height="40" alt=""></span>
           
            {!!$content!!}
             
        </div>
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