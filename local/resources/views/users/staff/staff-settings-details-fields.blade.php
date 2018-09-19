<?php $new_tab_active = '';
	if($tab_active=='settings')
		$new_tab_active = ' in active';
 ?>
<div id="settings" class="tab-pane fade {{$new_tab_active}}">
								<form action="">
									<h3>Settings</h3>
									<div class="row">
										<fieldset class="form-group col-md-6">
											<label for="exampleInputEmail1">Biometric ID</label>
											<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Biometric ID">
										</fieldset>
										<fieldset class='col-sm-6'>
											<label for="exampleInputEmail1">Gender</label>
											<div class="form-group row">
												<div class="col-md-6">
													<input type="checkbox" checked="" id="enableSMSFeatures" name="">
													<label for="enableSMSFeatures"> <span class="fa-stack checkbox-button"> <i class="mdi mdi-check active"></i> </span> Enable SMS Features </label>
												</div>
												<div class="col-md-6">
													<input type="checkbox" id="enableEmailFeatures" name="">
													<label for="enableEmailFeatures"> <span class="fa-stack checkbox-button"> <i class="mdi mdi-check active"></i> </span> Enable Email Features </label>
												</div>
											</div>
										</fieldset>

									</div>

									<h3>Media</h3>
									<div class="row">
										<fieldset class='col-sm-6 form-group' >
											<label for="exampleTextarea">Upload User’s Photo</label>
											<div class="input-group">
												<input type="file" class="form-control" value="" placeholder="Select file" >
												<span class="input-group-btn">
											<button class="btn btn-primary button btn-lg" type="button">Upload</button>
											</span>
											</div>
										</fieldset>

										<fieldset class='col-sm-6 form-group'>
											<label for="">Upload Documents</label>
											<div class="input-group">

												<input type="file" class="form-control" value="" placeholder="Select file" >
												<span class="input-group-btn">
											<button class="btn btn-primary button btn-lg" type="button">Upload</button>
											</span>
											</div>
										</fieldset>
									</div>

									<div class="buttons text-center">
										<button class="btn btn-lg btn-success button">Save Details</button>
									</div>
								</form>

							</div>