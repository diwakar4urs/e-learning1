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
                        <a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">
                            {{getPhrase('academic_operations')}}
                        </a>
                    </li>


                    <li>
                        <a href="{{URL_CERTIFICATES_DASHBOARD}}">
                            {{getPhrase('certificates_dashboard')}}
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
                 
                 
                    <div class="col-md-12">
                    <fieldset class="form-group col-md-6">  
                {{ Form::label('type', getphrase('certificate_type')) }}

                <select name="certificate_type" id="certificate_type" class="form-control" ng-change="certificateTypeChanged(selected_certificate_type)" ng-model="selected_certificate_type">
                    <option value="bonafide">Bonafide</option>
                    <option value="tc">TC</option>
                </select>

                </fieldset>

                        <fieldset class="form-group  col-md-6">
                        {{ Form::label ('search', getphrase('search')) }}
                    <input type="text" class="form-control" name="search" id="enter-details" ng-model="search" placeholder="{{'search'}}" ng-change="textChanged(search)">
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
            <th ng-if="selected_certificate_type!='tc'">{{getPhrase('year')}}-{{getPhrase('semester')}}</th>
           <th ng-if="selected_certificate_type=='tc'">{{getPhrase('status')}}</th>

        </thead>
        <tbody>
        <tr ng-repeat="user in users" id="@{{'selected_'+user.id}}" ng-click="getUserDetails(user)">
            <td>
            
            <img ng-if="user.image!=null && user.image!=''" class="thumb" src="{{IMAGE_PATH_PROFILE}}@{{user.image}}" height="60">
            
            <img ng-if="user.image==null || user.image==''" class="thumb" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}">
            </td>
            <td>@{{user.name}}</td>
            <td>@{{user.roll_no}}</td>
            <td>@{{user.admission_no}}</td>
            <td> @{{user.academic_year_title+' '+user.course_title}} </td>
            <td> <span ng-if = "user.course_dueration<=1">-</span>
                <span ng-if="user.current_year!=-1"><span ng-if="user.course_dueration>1"> @{{user.current_year}}</span></span>
                <span ng-if="user.current_semister!=0"><span ng-if="user.current_semister!=-1"> - @{{user.current_semister}}</span> </span> 
                <span ng-show="user.current_year==-1" >{{getPhrase('completed')}}</span>
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

    @include('certificates.students.scripts.js-scripts')
    
@stop

@section('custom_div_end')
</div>
@stop