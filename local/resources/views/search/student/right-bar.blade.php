<div class="panel-heading">
		<h2>User Profile</h2></div>
 
<div ng-if="selected_user==null || selected_user==''" class="panel-body">
Select User to view details
</div>

	
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
 
                 
				 <table class="table">
				 	<tbody>
				 		<tr>
				 			<th>Roll No:</th>
				 			<th>@{{selected_user.roll_no}}</th>
				 		</tr>
				 		<tr>
				 			<th>Admission No:</th>
				 			<th>@{{selected_user.admission_no}}</th>
				 		</tr>
				 		<tr>
				 			<th>DOJ</th>
				 			<th>@{{selected_user.date_of_join}}</th>
				 		</tr>
				 		<tr>
				 			<th>Course</th>
				 			<th>@{{selected_user.course_title}}</th>
				 		</tr>
				 		<tr ng-if="selected_user.course_dueration>1">
				 			<th>Year <span ng-if="selected_user.current_semister>0">- Sem</span></th>
				 			<th>@{{selected_user.current_year}} 
				 			<span ng-if="selected_user.current_semister>0">@{{selected_user.current_semister}}</span>
				 			</th>
				 		</tr>
				 		<tr>
				 			<th>Email</th>
				 			<th>@{{selected_user.email}}</th>
				 		</tr>

				 		<tr>
				 			<th>Phone</th>
				 			<th>@{{selected_user.mobile}}
				 			<span ng-if="selected_user.home_phone">
				 				, @{{selected_user.home_phone}}
				 			</span>
				 			</th>
				 		</tr>
				 		<tr ng-if="selected_user.blood_group">
				 			<th>Bld-Grp.</th>
				 			<th>@{{selected_user.blood_group}}</th>
				 		</tr>
				 		<tr ng-if="selected_user.address_lane1">
				 			<th>Address</th>
				 			<th>@{{selected_user.address_lane1}}
				 			<span ng-if="selected_user.city">
				 				, @{{selected_user.city}}
				 			</span>
				 			<span ng-if="selected_user.state">
				 				, @{{selected_user.state}}
				 			</span>
				 			<span ng-if="selected_user.zipcode">
				 				, @{{selected_user.zipcode}}
				 			</span>
				 			</th>
				 		</tr>
				 		<tr ng-if="selected_user.fathers_name">
				 			<th>Father</th>
				 			<th>@{{selected_user.fathers_name}}</th>
				 		</tr>
				 		<tr ng-if="selected_user.mothers_name">
				 			<th>Mother</th>
				 			<th>@{{selected_user.mothers_name}}</th>
				 		</tr>


				 	</tbody>
				 </table>
				 <a class="btn btn-link pull-right" href="{{URL_USER_DETAILS}}@{{selected_user.slug}}">View more >></a>

		