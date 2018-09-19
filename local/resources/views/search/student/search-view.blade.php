@extends($layout)

@section('header_scripts')
 

@stop

@section('custom_div')
<div ng-controller="TabController">
@stop

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{PREFIX}}">
                            <i class="mdi mdi-home">
                            </i>
                        </a>
                    </li>
                    <li>
                        <a href="{{URL_USERS."student"}}">
                            {{getPhrase('students')}}
                        </a>
                    </li>


                     
                    <li>
                        
                            {{$title}}
                        
                    </li>
                </ol>
            </div>
        </div>
    
        


        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{getPhrase('select_details')}}
                 
                </h1>
            </div>
            <div class="panel-body instruction">
                <div class="row">
                 
                 
                    <div class="col-md-6 col-md-offset-3">
                   

                        <fieldset class="form-group">
                        {{ Form::label ('search', getphrase('search')) }}
                    <input type="text" class="form-control" name="search" ng-model="search" placeholder="{{'search'}}" ng-change="textChanged(search)">
                        </fieldset>
                        
                         
            </div>
            
                </div>
                <hr>
 
  

    <div class="row vertical-scroll table-responsive" >
        <table class="table">
        <thead>
            <th>{{getPhrase('image')}}</th>
            <th>{{getPhrase('name')}}</th>
            <th>{{getPhrase('roll_no')}}</th>
            <th>{{getPhrase('admission_no')}}</th>
            <th>{{getPhrase('class')}}</th>
            <th>{{getPhrase('year')}}-{{getPhrase('semester')}}</th>
        </thead>
        <tbody>
        <tr ng-repeat="user in users" id="@{{'selected_'+user.id}}" ng-click="getUserDetails(user)">
            <td valign="middle">
            
            <img ng-if="user.image!=null && user.image!=''" class="thumb" src="{{IMAGE_PATH_PROFILE}}@{{user.image}}" height="60">
            
            <img ng-if="user.image==null || user.image==''" class="thumb" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}">
            </td>
            <td valign="middle">@{{user.name}}</td>
            <td valign="middle">@{{user.roll_no}}</td>
            <td valign="middle">@{{user.admission_no}}</td>
            <td valign="middle"> @{{user.academic_title+' '+user.course_title}} </td>
            <td valign="middle"> @{{user.current_year}} 
                <span ng-if="user.current_semister!=0"> - @{{user.current_semister}}</span> 
            </td>
        </tr>
    </tbody>
        </table>
    </div>
                            
                       
                    
        <hr>

            </div>
        </div>
    </div>
</div>

@stop
 
 

@section('footer_scripts')

    @include('search.scripts.js-scripts')
    
@stop

@section('custom_div_end')
</div>
@stop