<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<!-- Logo -->
	<div class="sidebar-logo">
		<a href="{{ url('/') }}" class="logo logo-normal">
			<img src="{{ asset('assets/img/logo.svg') }}" alt="Logo">
		</a>
		<a href="{{ url('/') }}" class="logo-small">
			<img src="{{ asset('assets/img/logo-small.svg') }}" alt="Logo">
		</a>
		<a href="{{ url('/') }}" class="dark-logo">
			<img src="{{ asset('assets/img/logo-white.svg') }}" alt="Logo">
		</a>
	</div>
	<!-- /Logo -->
	<div class="modern-profile p-3 pb-0">
		<div class="text-center rounded bg-light p-3 mb-4 user-profile">
			<div class="avatar avatar-lg online mb-3">
				<img src="{{ asset('assets/img/profiles/avatar-02.jpg') }}" alt="Img" class="img-fluid rounded-circle">
			</div>
			<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
			<p class="fs-10">System Admin</p>
		</div>
		<div class="sidebar-nav mb-3">
			<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
				<li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
				<li class="nav-item"><a class="nav-link border-0" href="{{ url('/chat') }}">Chats</a></li>
				<li class="nav-item"><a class="nav-link border-0" href="{{ url('/email') }}">Inbox</a></li>
			</ul>
		</div>
	</div>
	<div class="sidebar-header p-3 pb-0 pt-2">
		<div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
			<div class="avatar avatar-md onlin">
				<img src="{{ asset('assets/img/profiles/avatar-02.jpg') }}" alt="Img" class="img-fluid rounded-circle">
			</div>
			<div class="text-start sidebar-profile-info ms-2">
				<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
				<p class="fs-10">System Admin</p>
			</div>
		</div>
		<div class="input-group input-group-flat d-inline-flex mb-4">
			<span class="input-icon-addon">
				<i class="ti ti-search"></i>
			</span>
			<input type="text" class="form-control" placeholder="Search in HRMS">
			<span class="input-group-text">
				<kbd>CTRL + / </kbd>
			</span>
		</div>
		<div class="d-flex align-items-center justify-content-between menu-item mb-3">
			<div class="me-3">
				<a href="{{ url('/calendar') }}" class="btn btn-menubar">
					<i class="ti ti-layout-grid-remove"></i>
				</a>
			</div>
			<div class="me-3">
				<a href="{{ url('/chat') }}" class="btn btn-menubar position-relative">
					<i class="ti ti-brand-hipchat"></i>
					<span class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
				</a>
			</div>
			<div class="me-3 notification-item">
				<a href="{{ url('/activity') }}" class="btn btn-menubar position-relative me-1">
					<i class="ti ti-bell"></i>
					<span class="notification-status-dot"></span>
				</a>
			</div>
			<div class="me-0">
				<a href="{{ url('/email') }}" class="btn btn-menubar">
					<i class="ti ti-message"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="menu-title"><span>HRM</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ url('/') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
								<i class="ti ti-layout-dashboard"></i><span>Dashboard</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/employees') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
								<i class="ti ti-users"></i><span>Employee</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/departments') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
								<i class="ti ti-building"></i><span>Departments</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/designations') }}" class="{{ request()->routeIs('designations.*') ? 'active' : '' }}">
								<i class="ti ti-briefcase"></i><span>Designations</span>
							</a>
						</li>
						<li class="submenu {{ request()->is('onboarding*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('onboarding*') ? 'active subdrop' : '' }}">
								<i class="ti ti-user-plus"></i><span>Onboarding</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('onboarding*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/onboarding') }}" class="{{ request()->is('onboarding') && !request()->is('onboarding/*') ? 'active' : '' }}">Onboarding List</a></li>
								<li><a href="{{ url('/onboarding/templates') }}" class="{{ request()->is('onboarding/templates') ? 'active' : '' }}">Onboarding Templates</a></li>
								<li><a href="{{ url('/onboarding/checklist') }}" class="{{ request()->is('onboarding/checklist') ? 'active' : '' }}">Onboarding Checklist</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('self-service*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('self-service*') ? 'active subdrop' : '' }}">
								<i class="ti ti-user-circle"></i><span>Employee Self-Service</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('self-service*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/self-service/profile') }}" class="{{ request()->is('self-service/profile') ? 'active' : '' }}">My Profile</a></li>
								<li><a href="{{ url('/self-service/documents') }}" class="{{ request()->is('self-service/documents') ? 'active' : '' }}">My Documents</a></li>
								<li><a href="{{ url('/self-service/requests') }}" class="{{ request()->is('self-service/requests') ? 'active' : '' }}">My Requests</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('documents*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('documents*') ? 'active subdrop' : '' }}">
								<i class="ti ti-file-text"></i><span>Documents</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('documents*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/documents') }}" class="{{ request()->is('documents') && !request()->is('documents/*') ? 'active' : '' }}">Document Library</a></li>
								<li><a href="{{ url('/documents/letters') }}" class="{{ request()->is('documents/letters') ? 'active' : '' }}">HR Letters</a></li>
								<li><a href="{{ url('/documents/certificates') }}" class="{{ request()->is('documents/certificates') ? 'active' : '' }}">Certificates</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('tickets*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('tickets*') ? 'active subdrop' : '' }}">
								<i class="ti ti-ticket"></i><span>Tickets</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('tickets*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/tickets') }}" class="{{ request()->is('tickets') && !request()->is('tickets/*') ? 'active' : '' }}">Tickets</a></li>
								<li><a href="{{ url('/tickets/details') }}" class="{{ request()->is('tickets/details') ? 'active' : '' }}">Ticket Details</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/holidays') }}" class="{{ request()->is('holidays*') ? 'active' : '' }}">
								<i class="ti ti-calendar-event"></i><span>Holidays</span>
							</a>
						</li>
						<li class="submenu {{ request()->is('attendance*') || request()->is('leaves*') || request()->is('timesheets*') || request()->is('schedule*') || request()->is('overtime*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('attendance*') || request()->is('leaves*') || request()->is('timesheets*') || request()->is('schedule*') || request()->is('overtime*') ? 'active subdrop' : '' }}">
								<i class="ti ti-file-time"></i><span>Attendance</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('attendance*') || request()->is('leaves*') || request()->is('timesheets*') || request()->is('schedule*') || request()->is('overtime*') ? 'display: block;' : '' }}">
								<li class="submenu submenu-two {{ request()->is('leaves*') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('leaves*') ? 'active subdrop' : '' }}">Leaves<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('leaves*') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/leaves') }}" class="{{ request()->is('leaves') && !request()->is('leaves/*') ? 'active' : '' }}">Leaves (Admin)</a></li>
										<li><a href="{{ url('/leaves/employee') }}" class="{{ request()->is('leaves/employee') ? 'active' : '' }}">Leave (Employee)</a></li>
										<li><a href="{{ url('/leaves/settings') }}" class="{{ request()->is('leaves/settings') ? 'active' : '' }}">Leave Settings</a></li>												
									</ul>												
								</li>
								<li><a href="{{ url('/attendance/admin') }}" class="{{ request()->is('attendance/admin') ? 'active' : '' }}">Attendance (Admin)</a></li>
								<li><a href="{{ url('/attendance/employee') }}" class="{{ request()->is('attendance/employee') ? 'active' : '' }}">Attendance (Employee)</a></li>
								<li><a href="{{ url('/timesheets') }}" class="{{ request()->is('timesheets*') ? 'active' : '' }}">Timesheets</a></li>
								<li><a href="{{ url('/schedule') }}" class="{{ request()->is('schedule*') ? 'active' : '' }}">Shift & Schedule</a></li>
								<li><a href="{{ url('/overtime') }}" class="{{ request()->is('overtime*') ? 'active' : '' }}">Overtime</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('performance*') || request()->is('goals*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('performance*') || request()->is('goals*') ? 'active subdrop' : '' }}">
								<i class="ti ti-school"></i><span>Performance</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('performance*') || request()->is('goals*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/performance/indicator') }}" class="{{ request()->is('performance/indicator') ? 'active' : '' }}">Performance Indicator</a></li>
								<li><a href="{{ url('/performance/review') }}" class="{{ request()->is('performance/review') ? 'active' : '' }}">Performance Review</a></li>
								<li><a href="{{ url('/performance/appraisal') }}" class="{{ request()->is('performance/appraisal') ? 'active' : '' }}">Performance Appraisal</a></li>
								<li><a href="{{ url('/goals') }}" class="{{ request()->is('goals') && !request()->is('goals/*') ? 'active' : '' }}">Goal List</a></li>
								<li><a href="{{ url('/goals/types') }}" class="{{ request()->is('goals/types') ? 'active' : '' }}">Goal Type</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('training*') || request()->is('trainers*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('training*') || request()->is('trainers*') ? 'active subdrop' : '' }}">
								<i class="ti ti-edit"></i><span>Training</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('training*') || request()->is('trainers*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/training') }}" class="{{ request()->is('training') && !request()->is('training/*') ? 'active' : '' }}">Training List</a></li>
								<li><a href="{{ url('/trainers') }}" class="{{ request()->is('trainers*') ? 'active' : '' }}">Trainers</a></li>
								<li><a href="{{ url('/training/types') }}" class="{{ request()->is('training/types') ? 'active' : '' }}">Training Type</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/promotion') }}" class="{{ request()->is('promotion*') ? 'active' : '' }}">
								<i class="ti ti-speakerphone"></i><span>Promotion</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/resignation') }}" class="{{ request()->is('resignation*') ? 'active' : '' }}">
								<i class="ti ti-external-link"></i><span>Resignation</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/termination') }}" class="{{ request()->is('termination*') ? 'active' : '' }}">
								<i class="ti ti-circle-x"></i><span>Termination</span>
							</a>
						</li>
						<li class="submenu {{ request()->is('surveys*') || request()->is('recognition*') || request()->is('announcements*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('surveys*') || request()->is('recognition*') || request()->is('announcements*') ? 'active subdrop' : '' }}">
								<i class="ti ti-heart-handshake"></i><span>Employee Engagement</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('surveys*') || request()->is('recognition*') || request()->is('announcements*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/surveys') }}" class="{{ request()->is('surveys*') ? 'active' : '' }}">Employee Surveys</a></li>
								<li><a href="{{ url('/recognition') }}" class="{{ request()->is('recognition*') ? 'active' : '' }}">Recognition & Rewards</a></li>
								<li><a href="{{ url('/announcements') }}" class="{{ request()->is('announcements*') ? 'active' : '' }}">Announcements</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('benefits*') || request()->is('loans*') || request()->is('advances*') || request()->is('reimbursements*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('benefits*') || request()->is('loans*') || request()->is('advances*') || request()->is('reimbursements*') ? 'active subdrop' : '' }}">
								<i class="ti ti-wallet"></i><span>Benefits & Compensation</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('benefits*') || request()->is('loans*') || request()->is('advances*') || request()->is('reimbursements*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/benefits') }}" class="{{ request()->is('benefits*') ? 'active' : '' }}">Benefits Management</a></li>
								<li><a href="{{ url('/loans') }}" class="{{ request()->is('loans*') ? 'active' : '' }}">Loan Management</a></li>
								<li><a href="{{ url('/advances') }}" class="{{ request()->is('advances*') ? 'active' : '' }}">Advance Salary</a></li>
								<li><a href="{{ url('/reimbursements') }}" class="{{ request()->is('reimbursements*') ? 'active' : '' }}">Reimbursements</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="menu-title"><span>RECRUITMENT</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ url('/jobs') }}" class="{{ request()->is('jobs*') ? 'active' : '' }}">
								<i class="ti ti-timeline"></i><span>Jobs</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/candidates') }}" class="{{ request()->is('candidates*') ? 'active' : '' }}">
								<i class="ti ti-user-shield"></i><span>Candidates</span>
							</a>
						</li>
						<li class="submenu {{ request()->is('interviews*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('interviews*') ? 'active subdrop' : '' }}">
								<i class="ti ti-calendar-check"></i><span>Interview</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('interviews*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/interviews') }}" class="{{ request()->is('interviews') && !request()->is('interviews/*') ? 'active' : '' }}">Interview Schedule</a></li>
								<li><a href="{{ url('/interviews/feedback') }}" class="{{ request()->is('interviews/feedback') ? 'active' : '' }}">Interview Feedback</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('offers*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('offers*') ? 'active subdrop' : '' }}">
								<i class="ti ti-file-check"></i><span>Offer Management</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('offers*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/offers') }}" class="{{ request()->is('offers') && !request()->is('offers/*') ? 'active' : '' }}">Job Offers</a></li>
								<li><a href="{{ url('/offers/templates') }}" class="{{ request()->is('offers/templates') ? 'active' : '' }}">Offer Templates</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/referrals') }}" class="{{ request()->is('referrals*') ? 'active' : '' }}">
								<i class="ti ti-ux-circle"></i><span>Referrals</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="menu-title"><span>FINANCE & ACCOUNTS</span></li>
				<li>
					<ul>
						<li class="submenu {{ request()->is('payroll*') || request()->is('provident-fund*') || request()->is('taxes*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('payroll*') || request()->is('provident-fund*') || request()->is('taxes*') ? 'active subdrop' : '' }}">
								<i class="ti ti-cash"></i><span>Payroll</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('payroll*') || request()->is('provident-fund*') || request()->is('taxes*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/payroll/salary') }}" class="{{ request()->is('payroll/salary') ? 'active' : '' }}">Employee Salary</a></li>
								<li><a href="{{ url('/payroll/payslip') }}" class="{{ request()->is('payroll/payslip') ? 'active' : '' }}">Payslip</a></li>
								<li><a href="{{ url('/payroll/items') }}" class="{{ request()->is('payroll/items') ? 'active' : '' }}">Payroll Items</a></li>
								<li><a href="{{ url('/provident-fund') }}" class="{{ request()->is('provident-fund*') ? 'active' : '' }}">Provident Fund</a></li>
								<li><a href="{{ url('/taxes') }}" class="{{ request()->is('taxes*') ? 'active' : '' }}">Taxes</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('expenses*') || request()->is('categories*') || request()->is('budgets*') || request()->is('budget-expenses*') || request()->is('budget-revenues*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('expenses*') || request()->is('categories*') || request()->is('budgets*') || request()->is('budget-expenses*') || request()->is('budget-revenues*') ? 'active subdrop' : '' }}">
								<i class="ti ti-file-dollar"></i><span>Accounting</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('expenses*') || request()->is('categories*') || request()->is('budgets*') || request()->is('budget-expenses*') || request()->is('budget-revenues*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/expenses') }}" class="{{ request()->is('expenses*') ? 'active' : '' }}">Expenses</a></li>
								<li><a href="{{ url('/categories') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">Categories</a></li>
								<li><a href="{{ url('/budgets') }}" class="{{ request()->is('budgets') && !request()->is('budgets/*') ? 'active' : '' }}">Budgets</a></li>
								<li><a href="{{ url('/budget-expenses') }}" class="{{ request()->is('budget-expenses*') ? 'active' : '' }}">Budget Expenses</a></li>
								<li><a href="{{ url('/budget-revenues') }}" class="{{ request()->is('budget-revenues*') ? 'active' : '' }}">Budget Revenues</a></li>
							</ul>
						</li>
					</ul>
				</li>						
				<li class="menu-title"><span>ADMINISTRATION</span></li>
				<li>
					<ul>
						<li class="submenu {{ request()->is('assets*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('assets*') ? 'active subdrop' : '' }}">
								<i class="ti ti-package"></i><span>Assets</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('assets*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/assets') }}" class="{{ request()->is('assets') && !request()->is('assets/*') ? 'active' : '' }}">Assets</a></li>
								<li><a href="{{ url('/assets/categories') }}" class="{{ request()->is('assets/categories') ? 'active' : '' }}">Asset Categories</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('users*') || request()->is('roles*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('users*') || request()->is('roles*') ? 'active subdrop' : '' }}">
								<i class="ti ti-user-star"></i><span>User Management</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('users*') || request()->is('roles*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/users') }}" class="{{ request()->is('users*') ? 'active' : '' }}">Users</a></li>
								<li><a href="{{ url('/roles') }}" class="{{ request()->is('roles*') ? 'active' : '' }}">Roles & Permissions</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('reports*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('reports*') ? 'active subdrop' : '' }}">
								<i class="ti ti-user-star"></i><span>Reports</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('reports*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/reports/employees') }}" class="{{ request()->is('reports/employees') ? 'active' : '' }}">Employee Report</a></li>
								<li><a href="{{ url('/reports/attendance') }}" class="{{ request()->is('reports/attendance') ? 'active' : '' }}">Attendance Report</a></li>
								<li><a href="{{ url('/reports/leaves') }}" class="{{ request()->is('reports/leaves') ? 'active' : '' }}">Leave Report</a></li>
								<li><a href="{{ url('/reports/payslips') }}" class="{{ request()->is('reports/payslips') ? 'active' : '' }}">Payslip Report</a></li>
								<li><a href="{{ url('/reports/expenses') }}" class="{{ request()->is('reports/expenses') ? 'active' : '' }}">Expense Report</a></li>
								<li><a href="{{ url('/reports/performance') }}" class="{{ request()->is('reports/performance') ? 'active' : '' }}">Performance Report</a></li>
								<li><a href="{{ url('/reports/training') }}" class="{{ request()->is('reports/training') ? 'active' : '' }}">Training Report</a></li>
								<li><a href="{{ url('/reports/recruitment') }}" class="{{ request()->is('reports/recruitment') ? 'active' : '' }}">Recruitment Report</a></li>
								<li><a href="{{ url('/reports/users') }}" class="{{ request()->is('reports/users') ? 'active' : '' }}">User Report</a></li>
								<li><a href="{{ url('/reports/daily') }}" class="{{ request()->is('reports/daily') ? 'active' : '' }}">Daily Report</a></li>
							</ul>
						</li>
						<li class="submenu {{ request()->is('settings*') || request()->is('policies*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('settings*') || request()->is('policies*') ? 'active subdrop' : '' }}">
								<i class="ti ti-settings"></i><span>Settings</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('settings*') || request()->is('policies*') ? 'display: block;' : '' }}">
								<li class="submenu submenu-two {{ request()->is('settings/profile') || request()->is('settings/security') || request()->is('settings/notifications') || request()->is('settings/apps') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('settings/profile') || request()->is('settings/security') || request()->is('settings/notifications') || request()->is('settings/apps') ? 'active subdrop' : '' }}">General Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('settings/profile') || request()->is('settings/security') || request()->is('settings/notifications') || request()->is('settings/apps') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/settings/profile') }}" class="{{ request()->is('settings/profile') ? 'active' : '' }}">Profile</a></li>
										<li><a href="{{ url('/settings/security') }}" class="{{ request()->is('settings/security') ? 'active' : '' }}">Security</a></li>
										<li><a href="{{ url('/settings/notifications') }}" class="{{ request()->is('settings/notifications') ? 'active' : '' }}">Notifications</a></li>
										<li><a href="{{ url('/settings/apps') }}" class="{{ request()->is('settings/apps') ? 'active' : '' }}">Connected Apps</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two {{ request()->is('settings/business') || request()->is('settings/seo') || request()->is('settings/localization') || request()->is('settings/prefixes') || request()->is('settings/preferences') || request()->is('settings/appearance') || request()->is('settings/language') || request()->is('settings/authentication') || request()->is('settings/ai') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('settings/business') || request()->is('settings/seo') || request()->is('settings/localization') || request()->is('settings/prefixes') || request()->is('settings/preferences') || request()->is('settings/appearance') || request()->is('settings/language') || request()->is('settings/authentication') || request()->is('settings/ai') ? 'active subdrop' : '' }}">Website Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('settings/business') || request()->is('settings/seo') || request()->is('settings/localization') || request()->is('settings/prefixes') || request()->is('settings/preferences') || request()->is('settings/appearance') || request()->is('settings/language') || request()->is('settings/authentication') || request()->is('settings/ai') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/settings/business') }}" class="{{ request()->is('settings/business') ? 'active' : '' }}">Business Settings</a></li>
										<li><a href="{{ url('/settings/seo') }}" class="{{ request()->is('settings/seo') ? 'active' : '' }}">SEO Settings</a></li>
										<li><a href="{{ url('/settings/localization') }}" class="{{ request()->is('settings/localization') ? 'active' : '' }}">Localization</a></li>
										<li><a href="{{ url('/settings/prefixes') }}" class="{{ request()->is('settings/prefixes') ? 'active' : '' }}">Prefixes</a></li>
										<li><a href="{{ url('/settings/preferences') }}" class="{{ request()->is('settings/preferences') ? 'active' : '' }}">Preferences</a></li>
										<li><a href="{{ url('/settings/appearance') }}" class="{{ request()->is('settings/appearance') ? 'active' : '' }}">Appearance</a></li>
										<li><a href="{{ url('/settings/language') }}" class="{{ request()->is('settings/language') ? 'active' : '' }}">Language</a></li>
										<li><a href="{{ url('/settings/authentication') }}" class="{{ request()->is('settings/authentication') ? 'active' : '' }}">Authentication</a></li>
										<li><a href="{{ url('/settings/ai') }}" class="{{ request()->is('settings/ai') ? 'active' : '' }}">AI Settings</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two {{ request()->is('settings/salary') || request()->is('settings/approval') || request()->is('settings/invoice') || request()->is('settings/leave-type') || request()->is('settings/custom-fields') || request()->is('policies*') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('settings/salary') || request()->is('settings/approval') || request()->is('settings/invoice') || request()->is('settings/leave-type') || request()->is('settings/custom-fields') || request()->is('policies*') ? 'active subdrop' : '' }}">App Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('settings/salary') || request()->is('settings/approval') || request()->is('settings/invoice') || request()->is('settings/leave-type') || request()->is('settings/custom-fields') || request()->is('policies*') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/settings/salary') }}" class="{{ request()->is('settings/salary') ? 'active' : '' }}">Salary Settings</a></li>
										<li><a href="{{ url('/settings/approval') }}" class="{{ request()->is('settings/approval') ? 'active' : '' }}">Approval Settings</a></li>
										<li><a href="{{ url('/settings/invoice') }}" class="{{ request()->is('settings/invoice') ? 'active' : '' }}">Invoice Settings</a></li>
										<li><a href="{{ url('/settings/leave-type') }}" class="{{ request()->is('settings/leave-type') ? 'active' : '' }}">Leave Type</a></li>
										<li><a href="{{ url('/settings/custom-fields') }}" class="{{ request()->is('settings/custom-fields') ? 'active' : '' }}">Custom Fields</a></li>
										<li><a href="{{ url('/policies') }}" class="{{ request()->is('policies*') ? 'active' : '' }}">Policies</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two {{ request()->is('settings/email') || request()->is('settings/email-templates') || request()->is('settings/sms') || request()->is('settings/sms-templates') || request()->is('settings/otp') || request()->is('settings/gdpr') || request()->is('settings/maintenance') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('settings/email') || request()->is('settings/email-templates') || request()->is('settings/sms') || request()->is('settings/sms-templates') || request()->is('settings/otp') || request()->is('settings/gdpr') || request()->is('settings/maintenance') ? 'active subdrop' : '' }}">System Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('settings/email') || request()->is('settings/email-templates') || request()->is('settings/sms') || request()->is('settings/sms-templates') || request()->is('settings/otp') || request()->is('settings/gdpr') || request()->is('settings/maintenance') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/settings/email') }}" class="{{ request()->is('settings/email') && !request()->is('settings/email-templates') ? 'active' : '' }}">Email Settings</a></li>
										<li><a href="{{ url('/settings/email-templates') }}" class="{{ request()->is('settings/email-templates') ? 'active' : '' }}">Email Templates</a></li>
										<li><a href="{{ url('/settings/sms') }}" class="{{ request()->is('settings/sms') && !request()->is('settings/sms-templates') ? 'active' : '' }}">SMS Settings</a></li>
										<li><a href="{{ url('/settings/sms-templates') }}" class="{{ request()->is('settings/sms-templates') ? 'active' : '' }}">SMS Templates</a></li>
										<li><a href="{{ url('/settings/otp') }}" class="{{ request()->is('settings/otp') ? 'active' : '' }}">OTP</a></li>
										<li><a href="{{ url('/settings/gdpr') }}" class="{{ request()->is('settings/gdpr') ? 'active' : '' }}">GDPR Cookies</a></li>
										<li><a href="{{ url('/settings/maintenance') }}" class="{{ request()->is('settings/maintenance') ? 'active' : '' }}">Maintenance Mode</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two {{ request()->is('settings/payment-gateways') || request()->is('settings/tax-rates') || request()->is('settings/currencies') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('settings/payment-gateways') || request()->is('settings/tax-rates') || request()->is('settings/currencies') ? 'active subdrop' : '' }}">Financial Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('settings/payment-gateways') || request()->is('settings/tax-rates') || request()->is('settings/currencies') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/settings/payment-gateways') }}" class="{{ request()->is('settings/payment-gateways') ? 'active' : '' }}">Payment Gateways</a></li>
										<li><a href="{{ url('/settings/tax-rates') }}" class="{{ request()->is('settings/tax-rates') ? 'active' : '' }}">Tax Rate</a></li>
										<li><a href="{{ url('/settings/currencies') }}" class="{{ request()->is('settings/currencies') ? 'active' : '' }}">Currencies</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two {{ request()->is('settings/custom-css') || request()->is('settings/custom-js') || request()->is('settings/cronjob') || request()->is('settings/storage') || request()->is('settings/ban-ip') || request()->is('settings/backup') || request()->is('settings/clear-cache') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('settings/custom-css') || request()->is('settings/custom-js') || request()->is('settings/cronjob') || request()->is('settings/storage') || request()->is('settings/ban-ip') || request()->is('settings/backup') || request()->is('settings/clear-cache') ? 'active subdrop' : '' }}">Other Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('settings/custom-css') || request()->is('settings/custom-js') || request()->is('settings/cronjob') || request()->is('settings/storage') || request()->is('settings/ban-ip') || request()->is('settings/backup') || request()->is('settings/clear-cache') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/settings/custom-css') }}" class="{{ request()->is('settings/custom-css') ? 'active' : '' }}">Custom CSS</a></li>
										<li><a href="{{ url('/settings/custom-js') }}" class="{{ request()->is('settings/custom-js') ? 'active' : '' }}">Custom JS</a></li>
										<li><a href="{{ url('/settings/cronjob') }}" class="{{ request()->is('settings/cronjob') ? 'active' : '' }}">Cronjob</a></li>
										<li><a href="{{ url('/settings/storage') }}" class="{{ request()->is('settings/storage') ? 'active' : '' }}">Storage</a></li>
										<li><a href="{{ url('/settings/ban-ip') }}" class="{{ request()->is('settings/ban-ip') ? 'active' : '' }}">Ban IP Address</a></li>
										<li><a href="{{ url('/settings/backup') }}" class="{{ request()->is('settings/backup') ? 'active' : '' }}">Backup</a></li>
										<li><a href="{{ url('/settings/clear-cache') }}" class="{{ request()->is('settings/clear-cache') ? 'active' : '' }}">Clear Cache</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->
