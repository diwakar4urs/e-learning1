<!DOCTYPE html>

<html>
<head>
<title>{{$title}}</title>
</head>

<body onload="printDiv()" >
    
    <div id="DivIdToPrint">
<table width="100%" cellspacing="0" cellpadding="0" style="">

      <tr>
        <td align="center">
            <span ><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" height="40" alt=""></span>
        </td>
      </tr>
    <tr>
        <td align="center">
           <h1 style="text-align:center;font-size:20px;">{{$timetable_title}}
    </h1>

        </td>
    </tr>
    
</table>   
<table width="100%" cellspacing="0" cellpadding="0" style="border-top:1px solid #ddd;border-left:1px solid #ddd;font-size:12px;font-family:Arial;font-weight:400; background:url({{IMAGE_PATH_SETTINGS.getSetting('watermark_image', 'certificate')}}) no-repeat; background-size: auto 100% ; background-position: center center; " >
   
    <tbody>

      <tr>
          <th style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;padding:5px 10px;">#</th>
          @foreach($allocated_periods->maximum_periods_set as $period)
          <th style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;padding:5px 10px;">
            {{$period->period_name}}
            <div>
              <small>{{$period->start_time.'-'.$period->end_time}}</small>
            </div>
          </th>
           
          @endforeach
      </tr>
      <?php $index = 1;?>  
        @foreach($allocated_periods->days as $day_record)
        <?php $day_record = (object)$day_record; ?>
        <tr>
          <th style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;padding:5px 10px;">
          {{ $day_record->day }}</th>
          @foreach($allocated_periods->timemaps[$index++]['periods'] as $period_record)
          <?php $period_record = (object)$period_record;?>
          <td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;padding:5px 10px;text-align:center;padding:3px 0px;">
              @if(!$period_record->is_break)
                @if($period_record->is_assigned)
                <div> 
                {{$period_record->course_title}}
                {{$period_record->subject_title}} ({{$period_record->subject_code}})</div> 
                <div style="padding:3px 0px;">by {{$period_record->name}} ({{$period_record->staff_id}}) &nbsp;&nbsp;
                </div>
                  @if($period_record->is_lab)  
                  <div style="display:inline-block;float:right;margin-right:4px;">
                    <img src="{{IMAGES}}lab.png" alt="lab"> 
                  </div>
                  @endif
                  @if($period_record->is_elective)  
                  <div style="margin-right:2px;display:inline-block;float:right">
                    <img src="{{IMAGES}}icon2.png" alt="lab"> 
                  </div>
                  @endif
                @else
                  <div>{{getPhrase('leasure')}}</div>
                @endif
              @else
                <div>{{getPhrase('break')}}</div>
              @endif
          </td>
 
          @endforeach
      </tr>  
         @endforeach
 
    </tbody>
    
</table>
    {!!$notes!!}
    
    </div> 
    <br><p align="right"><b>{{getPhrase('printed_on: ')}}</b><b>{{date('d M Y')}}</b><b>{{date(" g:i a")}}</b></p>
                   

</body>



</html>