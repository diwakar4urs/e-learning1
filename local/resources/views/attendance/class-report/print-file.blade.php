
<h1><b>{{$title}}</b></h1><br/>
<div class="row vertical-scroll">
  
    <table style="border-collapse: collapse;">
    <thead>
        <th style="border:1px solid #000;">{{getPhrase('sno')}}</th>
        <th style="border:1px solid #000;" >{{getPhrase('name')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('roll_no')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('total_class')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('present')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('absent')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('leave')}}</th>
        <th style="border:1px solid #000;">%</th>
        
    </thead>
    <tbody>
     @foreach($summary_attendance as $report)
    
    <tr>

        <td style="border:1px solid #000;">{{$report['sno']}}</td>
        <td style="border:1px solid #000;">{{$report['name']}}</td>
        <td style="border:1px solid #000;">{{$report['roll_no']}}</td>
        <td style="border:1px solid #000;">{{$report['total_classes']}}</td>
        <td style="border:1px solid #000;">{{$report['present']}}</td>
        <td style="border:1px solid #000;">{{$report['absent']}}</td>
        <td style="border:1px solid #000;">{{$report['leave']}}</td>
        <td style="border:1px solid #000;">{{$report['percentage']}}%</td>
       
       
    </tr> 
    @endforeach
    </tbody>
    </table>
</div>