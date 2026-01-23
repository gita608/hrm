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
							<a href="{{ url('/employees') }}">
								<i class="ti ti-users"></i><span>Employee</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/departments') }}">
								<i class="ti ti-building"></i><span>Departments</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/designations') }}">
								<i class="ti ti-briefcase"></i><span>Designations</span>
							</a>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-user-plus"></i><span>Onboarding</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/onboarding') }}">Onboarding List</a></li>
								<li><a href="{{ url('/onboarding/templates') }}">Onboarding Templates</a></li>
								<li><a href="{{ url('/onboarding/checklist') }}">Onboarding Checklist</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-user-circle"></i><span>Employee Self-Service</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/self-service/profile') }}">My Profile</a></li>
								<li><a href="{{ url('/self-service/documents') }}">My Documents</a></li>
								<li><a href="{{ url('/self-service/requests') }}">My Requests</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-file-text"></i><span>Documents</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/documents') }}">Document Library</a></li>
								<li><a href="{{ url('/documents/letters') }}">HR Letters</a></li>
								<li><a href="{{ url('/documents/certificates') }}">Certificates</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-ticket"></i><span>Tickets</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/tickets') }}">Tickets</a></li>
								<li><a href="{{ url('/tickets/details') }}">Ticket Details</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/holidays') }}">
								<i class="ti ti-calendar-event"></i><span>Holidays</span>
							</a>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-file-time"></i><span>Attendance</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">Leaves<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/leaves') }}">Leaves (Admin)</a></li>
										<li><a href="{{ url('/leaves/employee') }}">Leave (Employee)</a></li>
										<li><a href="{{ url('/leaves/settings') }}">Leave Settings</a></li>												
									</ul>												
								</li>
								<li><a href="{{ url('/attendance/admin') }}">Attendance (Admin)</a></li>
								<li><a href="{{ url('/attendance/employee') }}">Attendance (Employee)</a></li>
								<li><a href="{{ url('/timesheets') }}">Timesheets</a></li>
								<li><a href="{{ url('/schedule') }}">Shift & Schedule</a></li>
								<li><a href="{{ url('/overtime') }}">Overtime</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-school"></i><span>Performance</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/performance/indicator') }}">Performance Indicator</a></li>
								<li><a href="{{ url('/performance/review') }}">Performance Review</a></li>
								<li><a href="{{ url('/performance/appraisal') }}">Performance Appraisal</a></li>
								<li><a href="{{ url('/goals') }}">Goal List</a></li>
								<li><a href="{{ url('/goals/types') }}">Goal Type</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-edit"></i><span>Training</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/training') }}">Training List</a></li>
								<li><a href="{{ url('/trainers') }}">Trainers</a></li>
								<li><a href="{{ url('/training/types') }}">Training Type</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/promotion') }}">
								<i class="ti ti-speakerphone"></i><span>Promotion</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/resignation') }}">
								<i class="ti ti-external-link"></i><span>Resignation</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/termination') }}">
								<i class="ti ti-circle-x"></i><span>Termination</span>
							</a>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-heart-handshake"></i><span>Employee Engagement</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/surveys') }}">Employee Surveys</a></li>
								<li><a href="{{ url('/recognition') }}">Recognition & Rewards</a></li>
								<li><a href="{{ url('/announcements') }}">Announcements</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-wallet"></i><span>Benefits & Compensation</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/benefits') }}">Benefits Management</a></li>
								<li><a href="{{ url('/loans') }}">Loan Management</a></li>
								<li><a href="{{ url('/advances') }}">Advance Salary</a></li>
								<li><a href="{{ url('/reimbursements') }}">Reimbursements</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="menu-title"><span>RECRUITMENT</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ url('/jobs') }}">
								<i class="ti ti-timeline"></i><span>Jobs</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/candidates') }}">
								<i class="ti ti-user-shield"></i><span>Candidates</span>
							</a>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-calendar-check"></i><span>Interview</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/interviews') }}">Interview Schedule</a></li>
								<li><a href="{{ url('/interviews/feedback') }}">Interview Feedback</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-file-check"></i><span>Offer Management</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/offers') }}">Job Offers</a></li>
								<li><a href="{{ url('/offers/templates') }}">Offer Templates</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/referrals') }}">
								<i class="ti ti-ux-circle"></i><span>Referrals</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="menu-title"><span>FINANCE & ACCOUNTS</span></li>
				<li>
					<ul>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-cash"></i><span>Payroll</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/payroll/salary') }}">Employee Salary</a></li>
								<li><a href="{{ url('/payroll/payslip') }}">Payslip</a></li>
								<li><a href="{{ url('/payroll/items') }}">Payroll Items</a></li>
								<li><a href="{{ url('/provident-fund') }}">Provident Fund</a></li>
								<li><a href="{{ url('/taxes') }}">Taxes</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-file-dollar"></i><span>Accounting</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/expenses') }}">Expenses</a></li>
								<li><a href="{{ url('/categories') }}">Categories</a></li>
								<li><a href="{{ url('/budgets') }}">Budgets</a></li>
								<li><a href="{{ url('/budget-expenses') }}">Budget Expenses</a></li>
								<li><a href="{{ url('/budget-revenues') }}">Budget Revenues</a></li>
							</ul>
						</li>
					</ul>
				</li>						
				<li class="menu-title"><span>ADMINISTRATION</span></li>
				<li>
					<ul>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-package"></i><span>Assets</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/assets') }}">Assets</a></li>
								<li><a href="{{ url('/assets/categories') }}">Asset Categories</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-headset"></i><span>Help & Supports</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/knowledgebase') }}">Knowledge Base</a></li>
								<li><a href="{{ url('/activity') }}">Activities</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-user-star"></i><span>User Management</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/users') }}">Users</a></li>
								<li><a href="{{ url('/roles') }}">Roles & Permissions</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-user-star"></i><span>Reports</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li><a href="{{ url('/reports/employees') }}">Employee Report</a></li>
								<li><a href="{{ url('/reports/attendance') }}">Attendance Report</a></li>
								<li><a href="{{ url('/reports/leaves') }}">Leave Report</a></li>
								<li><a href="{{ url('/reports/payslips') }}">Payslip Report</a></li>
								<li><a href="{{ url('/reports/expenses') }}">Expense Report</a></li>
								<li><a href="{{ url('/reports/performance') }}">Performance Report</a></li>
								<li><a href="{{ url('/reports/training') }}">Training Report</a></li>
								<li><a href="{{ url('/reports/recruitment') }}">Recruitment Report</a></li>
								<li><a href="{{ url('/reports/users') }}">User Report</a></li>
								<li><a href="{{ url('/reports/daily') }}">Daily Report</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);">
								<i class="ti ti-settings"></i><span>Settings</span>
								<span class="menu-arrow"></span>
							</a>
							<ul>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">General Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/settings/profile') }}">Profile</a></li>
										<li><a href="{{ url('/settings/security') }}">Security</a></li>
										<li><a href="{{ url('/settings/notifications') }}">Notifications</a></li>
										<li><a href="{{ url('/settings/apps') }}">Connected Apps</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">Website Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/settings/business') }}">Business Settings</a></li>
										<li><a href="{{ url('/settings/seo') }}">SEO Settings</a></li>
										<li><a href="{{ url('/settings/localization') }}">Localization</a></li>
										<li><a href="{{ url('/settings/prefixes') }}">Prefixes</a></li>
										<li><a href="{{ url('/settings/preferences') }}">Preferences</a></li>
										<li><a href="{{ url('/settings/appearance') }}">Appearance</a></li>
										<li><a href="{{ url('/settings/language') }}">Language</a></li>
										<li><a href="{{ url('/settings/authentication') }}">Authentication</a></li>
										<li><a href="{{ url('/settings/ai') }}">AI Settings</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">App Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/settings/salary') }}">Salary Settings</a></li>
										<li><a href="{{ url('/settings/approval') }}">Approval Settings</a></li>
										<li><a href="{{ url('/settings/invoice') }}">Invoice Settings</a></li>
										<li><a href="{{ url('/settings/leave-type') }}">Leave Type</a></li>
										<li><a href="{{ url('/settings/custom-fields') }}">Custom Fields</a></li>
										<li><a href="{{ url('/policies') }}">Policies</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">System Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/settings/email') }}">Email Settings</a></li>
										<li><a href="{{ url('/settings/email-templates') }}">Email Templates</a></li>
										<li><a href="{{ url('/settings/sms') }}">SMS Settings</a></li>
										<li><a href="{{ url('/settings/sms-templates') }}">SMS Templates</a></li>
										<li><a href="{{ url('/settings/otp') }}">OTP</a></li>
										<li><a href="{{ url('/settings/gdpr') }}">GDPR Cookies</a></li>
										<li><a href="{{ url('/settings/maintenance') }}">Maintenance Mode</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">Financial Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/settings/payment-gateways') }}">Payment Gateways</a></li>
										<li><a href="{{ url('/settings/tax-rates') }}">Tax Rate</a></li>
										<li><a href="{{ url('/settings/currencies') }}">Currencies</a></li>
									</ul>
								</li>
								<li class="submenu submenu-two">
									<a href="javascript:void(0);">Other Settings<span class="menu-arrow inside-submenu"></span></a>
									<ul>
										<li><a href="{{ url('/settings/custom-css') }}">Custom CSS</a></li>
										<li><a href="{{ url('/settings/custom-js') }}">Custom JS</a></li>
										<li><a href="{{ url('/settings/cronjob') }}">Cronjob</a></li>
										<li><a href="{{ url('/settings/storage') }}">Storage</a></li>
										<li><a href="{{ url('/settings/ban-ip') }}">Ban IP Address</a></li>
										<li><a href="{{ url('/settings/backup') }}">Backup</a></li>
										<li><a href="{{ url('/settings/clear-cache') }}">Clear Cache</a></li>
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
