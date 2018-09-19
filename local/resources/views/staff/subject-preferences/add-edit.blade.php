@extends($layout)

@section('header_scripts')
<link href="{{CSS}}animate.css" rel="stylesheet">
@stop
@section('custom_div')
<div ng-controller="academicCourses" ng-init="ingAngData({{$items}})">
@stop

@section('content')
<div id="page-wrapper">
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <ol class="breadcrumb">
              <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
              
              <li class="active">{{isset($title) ? $title : ''}}</li>
            </ol>
          </div>
        </div>
          @include('errors.errors')
        <!-- /.row -->
        
        <div class="panel panel-custom academia_visiblelist_fix" data-spy="affix" data-offset-top="0" id="app">
          <div class="panel-heading">

          <h1>{{ $title }}  </h1>
          </div>
          <div class="panel-body form-auth-style " >
          <?php $button_name = getPhrase('create'); ?>
          
           <?php $button_name = getPhrase('update'); ?>
            {{ Form::model($record, 
            array('url' => URL_STAFF_SUBJECT_PREFERENCES.$record->slug, 
            'method'=>'post')) }}
          
         
           
    
        <div class="row">
          <div class="col-md-8">
<h2 class="selected-item-title">{{getPhrase('preferred_subjects')}}</h2>
       <div class='containerVertical' id="target"  ng-drop="true" ng-drop-success="onDropComplete($data,$event)">
       <div ng-if="!target_items.length" class="subject-placeholder"> No Item Selected</div>
              <div ng-repeat="item in target_items" class="items-sub" id="target_items-@{{item.id}}">@{{item.subject_title}}
              <input type="hidden" name="selected_list[]" data-myname="@{{item.subject_title}}" value="@{{item.id}}">
              <div class="buttons-right">
                
              <i class="fa fa-trash text-danger pull-right" ng-click="removeItem(item, target_items, 'target_items')"></i>

              <i ng-if="item.is_lab==1" class="fa fa-flask pull-right text-primary" title="{{getPhrase('lab')}}" aria-hidden="true"></i> 
           
          <i ng-if="item.is_elective_type==1" class="fa fa-hand-pointer-o pull-right text-info" title="{{getPhrase('elective')}}" aria-hidden="true"></i>
              </div>


              </div>

           </div>
    

           </div>
           <div class="col-md-4 instruction">
                <h3>{{ getPhrase('summary') }}</h3>
                        <ul class="guide">
                            <li>
                                <span class="answer">
                                    <i class="fa fa-book">
                                    </i>
                                </span>
                                {{getPhrase('subjects')}} &nbsp; @{{target_items_subjects}}

                            </li>
                            <li>
                                <span class="notanswer">
                                    <i class="fa fa-flask">
                                    </i>
                                </span>
                                {{getPhrase('labs')}} &nbsp; @{{target_items_labs}}
                            </li>
                            <li>
                                <span class="marked">
                                    <i class="fa fa-hand-pointer-o">
                                    </i>
                                </span>
                                {{getPhrase('electives')}} &nbsp; @{{target_items_electives}}
                            </li>
                            
                        </ul>
                    </div>
        </div>
     <hr>
    <div class="text-center">
      <button class="btn btn-primary btn-lg">Update</button>
    </div>
 


           
          {!! Form::close() !!}
           



          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

  
@stop

@section('custom_div_end')
</div>
@stop

@section('footer_scripts')
@include('staff.subject-preferences.scripts.js-scripts')
@include('common.affix-window-size-script', array('newId'=>'app'))
@include('common.alertify')
 @stop