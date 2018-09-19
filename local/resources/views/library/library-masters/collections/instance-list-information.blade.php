 <?php 
         $image_path = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
         if($master_record->image)
         	$image_path = IMAGE_PATH_UPLOAD_LIBRARY.$master_record->image;
 ?>
<div class="row">
					<div class="col-md-3">
							<div class="book-box card text-xs-center" >
							<div class="card-bgimages" style="background-image: url('{{$image_path}}'); "></div>
					 
									<div class="book-content">
									<h3 class="card-title">{{ $master_record->title }}</h3>
									<p class="card-text">
									{{ $master_record->author->author }} </p>
									<div class="availability">
										<span class="card-text">{{getPhrase('total')}}: {{ $master_record->total_assets_count }}</span>
									</div>
									</div>
									 
								</div>
					</div>
					
					<div class="col-md-3">
						<div class="card card-green text-xs-center">
							<div class="card-block">
								<h4 class="card-title">{{ $master_record->total_assets_available }}</h4>
								<p class="card-text">{{ getPhrase('available') }}</p>
							</div>
							<a class="card-footer text-muted">
								{{ getPhrase('view_all') }}
							</a>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-black text-xs-center">
								<div class="card-block">
								<h4 class="card-title">
								<?php $damaged= App\LibraryInstance::where('library_master_id','=',$master_record->id)
								->where('status','=','damaged')->get()->count();
								?>
								{{ $damaged }}</h4>
								<p class="card-text">{{ getPhrase('damaged') }}</p>
							</div>
							<a class="card-footer text-muted">
								{{ getPhrase('view_all') }}
							</a>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-red text-xs-center">
								<div class="card-block">
								<h4 class="card-title">
								   <?php $lost= App\LibraryInstance::where('library_master_id','=',$master_record->id)
								->where('status','=','lost')->get()->count();
								?>   
								{{ $lost }}</h4>
								<p class="card-text">{{ getPhrase('lost') }}</p>
							</div>
							<a class="card-footer text-muted">
								{{ getPhrase('view_all') }}
							</a>
						</div>
					</div>


				</div>