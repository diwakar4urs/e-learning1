
                <h1>
                    {{$asset_data->title.' '.getPhrase('details')}}
                 
                </h1>
            
    <table cellspacing="1px" cellpadding="10px" border="1px solid #ccc">
        <thead>
            <th width="50%"><h4><strong>{{getPhrase('asset_details')}}</strong></h4></th>
            <th><h4><strong>{{getPhrase('status_details')}}</strong></h4></th>
        </thead>
    <tbody>
        <tr>
        <td><strong>ISBN NO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->isbn}}</td>
        <td><strong>{{getPhrase('total')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->total_assets_count}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('master_asset_name_:')}}</strong> {{$asset_data->title}}</td>
        <td><strong>{{getPhrase('available')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->total_assets_available}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('asset_type')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$master_asset_name->asset_type}}</td>
        <td><strong>{{getPhrase('total_issued')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->total_assets_issued}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('author_name')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$author_name->author}}</td>
        <td><strong>{{getPhrase('total_damaged')}}&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->total_assets_damaged}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('publisher_name')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$publisher_name->publisher}}</td>
        <td><strong>{{getPhrase('total_lost')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->total_assets_lost}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('edition')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->edition}}</td>
        <td><strong>{{getPhrase('price')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{$asset_data->actual_price}}</td>
        </tr>
    </tbody>
    </table>
  

 