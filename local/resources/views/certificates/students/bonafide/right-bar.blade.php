<div class="panel-heading">
		<h2>{{getPhrase('certificate_issues_histroy')}}</h2></div>


<div ng-if="selected_user==null || selected_user==''" class="panel-body">
{{getPhrase('select_user_to_view_details')}}
</div>
 <div ng-hide="selected_user==null || selected_user==''">
	
	<div ng-if="selected_user!=null" class="panel-body">
		<div class="row">
			<div class="profile-details text-center">
				<div class="profile-img">
				
				  <img ng-if="selected_user.image!=null && selected_user.image!=''" class="thumb" src="{{IMAGE_PATH_PROFILE}}@{{selected_user.image}}" height="60">
            
            <img ng-if="selected_user.image==null || selected_user.image==''" class="thumb" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}">

				</div>
				<div class="aouther-school">
					<h2>@{{selected_user.name}}</h2>
					<p><span>@{{selected_user.course_title+' ('+selected_user.academic_year_title+')'}}</span><span ng-if="selected_user.current_year==-1" >{{getPhrase('completed')}}</span>
					<span ng-if="selected_user.current_year!=-1 && selected_user.course_dueration>1 && selected_user.is_having_semister==1">@{{selected_user.current_year +' Year'}} - @{{selected_user.current_semister +' Semester'}}</span><span ng-if="selected_user.current_year!=-1 && selected_user.course_dueration>1 && selected_user.is_having_semister==0">@{{selected_user.current_year +' Year'}}</span></p>
					<p><span>Roll: @{{selected_user.roll_no}}</span></p>
				</div>

			</div>
		</div>
		        </hr>
               <div ng-if="books_return>0 && certificate_type!='bonafide'" class="alert alert-warning">
                              <strong>{{getPhrase('Note:')}}</strong> @{{selected_user.name}} is need to return @{{books_return}} books in the library
                         </div>
                <div ng-hide="form_show" class="list-group vertical-scroll">
                <a ng-if="certificates_issued.length<=0" href="#" class="list-group-item">No certificates issued yet</a>


				  <a ng-if="certificates_issued.length>0" href="#" class="list-group-item" ng-repeat="certificate in certificates_issued"><strong>@{{certificate.certificate_type|uppercase}}</strong> certificate is issued on <strong>@{{certificate.created_at}}</strong> with reason <i>"@{{certificate.reason}}"</i></a>
				  
				</div>
				<hr>
				<div ng-if="books_return<=0 || certificate_type=='bonafide'">
				<a ng-hide="form_show" href="javascript:void(0);" class="btn btn-primary btn-small pull-right" ng-click="toggleForm()">Issue Certificate</a>
				</div>
				<a ng-show="form_show" href="javascript:void(0);" class="btn btn-primary btn-small pull-right" ng-click="toggleForm()">Hide Form</a>
				<br>

				<div ng-show="form_show">
				        {!! Form::open(array('url' => URL_ISSUE_CERTIFICATE, 'method' => 'POST', 'name'=>'idCards ','target'=>'_blank', 'novalidate'=>'')) !!}
					<div class="row" ng-if="selected_user!=null">

 				<fieldset class="form-group">  
 				{{ Form::label('certificate_type', getphrase('certificate_type')) }}
 				<input type="hidden" name="certificate_type" value="@{{selected_certificate_type}}">
 				<strong>@{{selected_certificate_type|uppercase}}</strong>
				
				</fieldset>
 				<fieldset class="form-group">  
 				{{ Form::label('purpose', getphrase('purpose')) }}

				<textarea rows="3" cols="10" class="form-control" name="purpose" required></textarea>
				<input type="hidden" name="user_id" value="@{{selected_user.id}}">
				</fieldset>

					<div class="buttons text-center">
					<button class="btn btn-lg btn-success button">Issue</button>

						</div>
				{!! Form::close() !!}
				</div>
	</div>
	</div>




	
	 
