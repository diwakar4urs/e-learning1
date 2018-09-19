
<h1><b>{{$title}}</b></h1><br/>
<div class="row vertical-scroll">
  
    <table style="border-collapse: collapse;">

    <thead>
        <th style="border:1px solid #000;">{{getPhrase('sno')}}</th>
        <th style="border:1px solid #000;" >{{getPhrase('name')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('roll_no')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('course')}}</th>
        @for($i=1; $i<=$extracols;$i++)
        <th style="border:1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        @endfor
       
        
    </thead>
    <tbody>
    <?php $sno =1;?>
     @foreach($records as $record)
    
    <tr>
        
        <td style="border:1px solid #000;">{{$sno++}}</td>
        <td style="border:1px solid #000;">{{$record['name']}}</td>
        <td style="border:1px solid #000;">{{$record['roll_no']}}</td>
        <td style="border:1px solid #000;">{{$record['course_title']}}</td>
         @for($i=1; $i<=$extracols;$i++)
        <th style="border:1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        @endfor
        
       
    </tr> 
    @endforeach
    </tbody>
    </table>
</div>