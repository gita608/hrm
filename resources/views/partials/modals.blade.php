<!-- Add Todo Modal -->
<div class="modal fade" id="add_todo">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add New Todo</h4>
				<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<form action="{{ url('/todo') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="mb-3">
								<label class="form-label">Todo Title</label>
								<input type="text" class="form-control" name="title">
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label class="form-label">Tag</label>
								<select class="select" name="tag">
									<option>Select</option>
									<option>Internal</option>
									<option>Projects</option>
									<option>Meetings</option>
									<option>Reminder</option> 	 
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label class="form-label">Priority</label>
								<select class="select" name="priority">
									<option>Select</option>
									<option>Medium</option>
									<option>High</option>
									<option>Low</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Descriptions</label>
								<div class="summernote"></div>
							</div>
						</div>
						<div class="col-12">
							<div class="mb-3">
								<label class="form-label">Add Assignee</label>
								<select class="select" name="assignee">
									<option>Select</option>
									<option>Sophie</option>
									<option>Cameron</option>
									<option>Doris</option>
									<option>Rufana</option>
								</select>
							</div>
						</div>
						<div class="col-12">
							<div class="mb-0">
								<label class="form-label">Status</label>
								<select class="select" name="status">
									<option>Select</option>
									<option>Completed</option>
									<option>Pending</option>
									<option>Onhold</option>
									<option>Inprogress</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Add New Todo</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Add Todo Modal -->

<!-- Add Project Modal -->
<div class="modal fade" id="add_project" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header header-border align-items-center justify-content-between">
				<div class="d-flex align-items-center">
					<h5 class="modal-title me-2">Add Project </h5>
					<p class="text-dark">Project ID : PRO-0004</p>
				</div>
				<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<div class="add-info-fieldset">
				<div class="add-details-wizard p-3 pb-0">
					<ul class="progress-bar-wizard d-flex align-items-center border-bottom">
						<li class="active p-2 pt-0">
							<h6 class="fw-medium">Basic Information</h6>
						</li>
						<li class="p-2 pt-0">									
							<h6 class="fw-medium">Members</h6>
						</li>
					</ul>
				</div>
				<fieldset id="first-field-file">
					<form action="{{ url('/projects') }}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
										<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
											<i class="ti ti-photo text-gray-2 fs-16"></i>
										</div>                                              
										<div class="profile-upload">
											<div class="mb-2">
												<h6 class="mb-1">Upload Project Logo</h6>
												<p class="fs-12">Image should be below 4 mb</p>
											</div>
											<div class="profile-uploader d-flex align-items-center">
												<div class="drag-upload-btn btn btn-sm btn-primary me-2">
													Upload
													<input type="file" class="form-control image-sign" name="logo" multiple="">
												</div>
												<a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Project Name</label>
										<input type="text" class="form-control" name="name">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Client</label>
										<select class="select" name="client">
											<option>Select</option>
											<option>Anthony Lewis</option>
											<option>Brian Villalobos</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Start Date</label>
												<div class="input-icon-end position-relative">
													<input type="text" class="form-control datetimepicker" name="start_date" placeholder="dd/mm/yyyy">
													<span class="input-icon-addon">
														<i class="ti ti-calendar text-gray-7"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">End Date</label>
												<div class="input-icon-end position-relative">
													<input type="text" class="form-control datetimepicker" name="end_date" placeholder="dd/mm/yyyy">
													<span class="input-icon-addon">
														<i class="ti ti-calendar text-gray-7"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Priority</label>
												<select class="select" name="priority">
													<option>Select</option>
													<option>High</option>
													<option>Medium</option>
													<option>Low</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Project Value</label>
												<input type="text" class="form-control" name="value" value="$">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-0">
										<label class="form-label">Description</label>
										<div class="summernote"></div>
									</div>
								</div>
							</div>								
						</div>
						<div class="modal-footer">
							<div class="d-flex align-items-center justify-content-end">
								<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
								<button class="btn btn-primary wizard-next-btn" type="button">Add Team Member</button>
							</div>
						</div>
					</form>
				</fieldset>
				<fieldset>
					<form action="{{ url('/projects') }}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label me-2">Team Members</label>
										<input class="input-tags form-control" placeholder="Add new" type="text" data-role="tagsinput" name="team_members" value="Jerald,Andrew,Philip,Davis">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label me-2">Team Leader</label>
										<input class="input-tags form-control" placeholder="Add new" type="text" data-role="tagsinput" name="team_leader" value="Hendry,James">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label me-2">Project Manager</label>
										<input class="input-tags form-control" placeholder="Add new" type="text" data-role="tagsinput" name="project_manager" value="Dwight">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Status</label>
										<select class="select" name="status">
											<option>Select</option>
											<option>Active</option>
											<option>Inactive</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div>
										<label class="form-label">Tags</label>
										<select class="select" name="tags">
											<option>Select</option>
											<option>High</option>
											<option>Low</option>
											<option>Medium</option>
										</select>
									</div>
								</div>
							</div>								
						</div>
						<div class="modal-footer">
							<div class="d-flex align-items-center justify-content-end">
								<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
								<button class="btn btn-primary" type="submit">Save</button>
							</div>
						</div>
					</form>
				</fieldset>
			</div>
		</div>
	</div>
</div>
<!-- /Add Project Modal -->

<!-- Add Leaves Modal -->
<div class="modal fade" id="add_leaves">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Leave Request</h4>
				<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<form action="{{ url('/leaves') }}" method="POST">
				@csrf
				<div class="modal-body pb-0">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">Employee Name</label>
								<select class="select" name="employee_id">
									<option>Select</option>
									<option>Anthony Lewis</option>
									<option>Brian Villalobos</option>
									<option>Harvey Smith</option>
								</select>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">Leave Type</label>
								<select class="select" name="leave_type">
									<option>Select</option>
									<option>Medical Leave</option>
									<option>Casual Leave</option>
									<option>Annual Leave</option>
								</select>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">From </label>
								<div class="input-icon-end position-relative">
									<input type="text" class="form-control datetimepicker" name="from_date" placeholder="dd/mm/yyyy">
									<span class="input-icon-addon">
										<i class="ti ti-calendar text-gray-7"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">To </label>
								<div class="input-icon-end position-relative">
									<input type="text" class="form-control datetimepicker" name="to_date" placeholder="dd/mm/yyyy">
									<span class="input-icon-addon">
										<i class="ti ti-calendar text-gray-7"></i>
									</span>
								</div>
							</div>
						</div>   
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">No of Days</label>
								<input type="text" class="form-control" name="days" disabled>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Remaining Days</label>
								<input type="text" class="form-control" name="remaining" disabled>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">Reason</label>
								<textarea class="form-control" rows="3" name="reason"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Add Leaves</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Add Leaves Modal -->

@stack('modals')
