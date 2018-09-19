<div class="subject-sidebar" id="subjectSidebar">

			<div class="panel panel-custom">

				<div class="panel-heading">

					<h2 class="text-uppercase subject-title"> <i class="icon-school-hub"></i> {{getPhrase('subjects')}} </h2>

				</div>

				<div class="panel-body subject-list-box">

					<ul>

					@foreach($subjects as $r)

						<li onclick="showSubjectQuestion('subject_{{$r->id}}');">

							<a href="javascript:void(0);">

								<i class="icon icon-folders"></i>

								<h6>{{ $r->subject_title }}</h6>
 
							</a>

						</li>

					@endforeach

						 

						 

					</ul>

				</div>

			</div>

		</div>