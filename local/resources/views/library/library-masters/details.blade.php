@extends($layout)

@section('header_scripts')

@stop

@section('content')
<div id="page-wrapper" ng-controller="TabController">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li><a href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">{{ getPhrase('library_dashboard')}}</a></li>
                            <li><a href="{{URL_LIBRARY_MASTERS}}">{{ getPhrase('library_masters')}}</a></li>
                    <li>
                        {{$title}}
                    </li>
                </ol>
            </div>
        </div>
    {!! Form::open(array('url' => URL_PRINT_LIBRAY_ASSET_DETAILS.$asset_data->slug, 'method' => 'POST', 'name'=>'htmlform ','target'=>'_blank', 'id'=>'htmlform', 'novalidate'=>'')) !!}

        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{$asset_data->title.' '.getPhrase('details')}}
                 
                </h1>
            </div>
            <div class="panel-body">
    <div class="row">
    <div class="col-lg-12">
    <div class="table-responsive">
    <table  class="table table-bordered table-grid-asset">
        <thead>
            <th width="50%"><h4><strong>{{getPhrase('asset_details')}}</strong></h4></th>
            <th><h4><strong>{{getPhrase('status_details')}}</strong></h4></th>
        </thead>
    <tbody>
        <tr>
        <td><strong>ISBN NO :</strong> {{$asset_data->isbn}}</td>
        <td><strong>{{getPhrase('total_:')}}</strong> {{$asset_data->total_assets_count}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('master_asset_name_:')}}</strong> {{$asset_data->title}}</td>
        <td><strong>{{getPhrase('available:')}}</strong> {{$asset_data->total_assets_available}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('asset_type_:')}}</strong> {{$master_asset_name->asset_type}}</td>
        <td><strong>{{getPhrase('total_issued_:')}}</strong> {{$asset_data->total_assets_issued}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('author_name:')}}</strong> {{$author_name->author}}</td>
        <td><strong>{{getPhrase('total_damaged_:')}}</strong> {{$asset_data->total_assets_damaged}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('publisher_name_:')}}</strong> {{$publisher_name->publisher}}</td>
        <td><strong>{{getPhrase('total_lost_:')}}</strong> {{$asset_data->total_assets_lost}}</td>
        </tr>
        <tr>
        <td><strong>{{getPhrase('edition_:')}}</strong> {{$asset_data->edition}}</td>
        <td><strong>{{getPhrase('price:')}}</strong> {{$asset_data->actual_price}}</td>
        </tr>
    </tbody>
    </table>
    </div>
</div>
</div>

<br>
<a href="{{URL_PRINT_LIBRAY_ASSET_DETAILS.$asset_data->slug}}" target="_blank" class="btn btn-primary pull-right">Print</a>
 </div>
  </div>
</div>
                            
                </hr>
            </div>
        </div>
    </div>
</div>

  

@stop
 
@section('footer_scripts')

       @include('library.library-masters.js-scripts')

@stop