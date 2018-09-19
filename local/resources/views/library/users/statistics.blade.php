<?php $librarySettings = getLibrarySettings(); 
$max_issues = getSetting('maximum_issues_student','library_settings');
if($role=='staff')
	$max_issues = getSetting('maximum_issues_staff','library_settings');
?>
<div class="row">
					<div class="col-md-3">
						<div class="card card-blue text-xs-center">
							<div class="card-block">
								<h4 class="card-title">
								{{$max_issues}}
								</h4>
								<p class="card-text">{{ getPhrase('maximum_allowed')}}</p>
							</div>
							 
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-yellow text-xs-center">
							<div class="card-block">
								<h4 class="card-title">{{ count($books_issued)}}</h4>
								<p class="card-text">{{ getPhrase('issued')}}</p>
							</div>
							
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-green text-xs-center">
							<div class="card-block">
								<h4 class="card-title">{{ $max_issues - count($books_issued)}}</h4>
								<p class="card-text">{{getPhrase('eligible')}}</p>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-red text-xs-center">
							<div class="card-block">
								<h4 class="card-title">{{ count($books_history)}}</h4>
								<p class="card-text">{{ getPhrase('transactions')}}</p>
							</div>
							
						</div>
					</div>
				</div>