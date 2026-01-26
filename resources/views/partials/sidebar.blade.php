<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<!-- Logo -->
	<div class="sidebar-logo">
		<a href="{{ url('/') }}" class="logo logo-normal">
			@if(\App\Helpers\SettingsHelper::appLogo())
				<img src="{{ \App\Helpers\SettingsHelper::appLogo() }}" 
					 alt="{{ \App\Helpers\SettingsHelper::appName() }}"
					 style="max-width: 100%; max-height: 40px; width: auto; height: auto; object-fit: contain; display: block;">
			@else
				<span class="fw-bold">{{ \App\Helpers\SettingsHelper::appName() }}</span>
			@endif
		</a>
		<a href="{{ url('/') }}" class="logo-small">
			@if(\App\Helpers\SettingsHelper::appLogo())
				<img src="{{ \App\Helpers\SettingsHelper::appLogo() }}" 
					 alt="{{ \App\Helpers\SettingsHelper::appName() }}"
					 style="max-width: 100%; max-height: 40px; width: auto; height: auto; object-fit: contain; display: block;">
			@else
				<span class="fw-bold fs-12">{{ \App\Helpers\SettingsHelper::appName() }}</span>
			@endif
		</a>
		<a href="{{ url('/') }}" class="dark-logo">
			@if(\App\Helpers\SettingsHelper::appLogoWhite())
				<img src="{{ \App\Helpers\SettingsHelper::appLogoWhite() }}" 
					 alt="{{ \App\Helpers\SettingsHelper::appName() }}"
					 style="max-width: 100%; max-height: 40px; width: auto; height: auto; object-fit: contain; display: block;">
			@else
				<span class="fw-bold text-white">{{ \App\Helpers\SettingsHelper::appName() }}</span>
			@endif
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
				<!-- Dashboard -->
				<li class="menu-title"><span>DASHBOARD</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ url('/') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
								<i class="ti ti-layout-dashboard"></i><span>Dashboard</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Organization Structure -->
				<li class="menu-title"><span>ORGANIZATION</span></li>
				<li>
					<ul>
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
					</ul>
				</li>

				<!-- Employee Management -->
				<li class="menu-title"><span>EMPLOYEE MANAGEMENT</span></li>
				<li>
					<ul>
						<li class="submenu {{ request()->is('attendance*') || request()->is('leaves*') || request()->is('timesheets*') || request()->is('schedule*') || request()->is('overtime*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('attendance*') || request()->is('leaves*') || request()->is('timesheets*') || request()->is('schedule*') || request()->is('overtime*') ? 'active subdrop' : '' }}">
								<i class="ti ti-file-time"></i><span>Attendance & Leaves</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('attendance*') || request()->is('leaves*') || request()->is('timesheets*') || request()->is('schedule*') || request()->is('overtime*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/attendance/admin') }}" class="{{ request()->is('attendance/admin') ? 'active' : '' }}">Attendance (Admin)</a></li>
								<li><a href="{{ url('/attendance/employee') }}" class="{{ request()->is('attendance/employee') ? 'active' : '' }}">Attendance (Employee)</a></li>
								<li class="submenu submenu-two {{ request()->is('leaves*') ? 'active' : '' }}">
									<a href="javascript:void(0);" class="{{ request()->is('leaves*') ? 'active subdrop' : '' }}">Leaves<span class="menu-arrow inside-submenu"></span></a>
									<ul style="{{ request()->is('leaves*') ? 'display: block;' : '' }}">
										<li><a href="{{ url('/leaves') }}" class="{{ request()->is('leaves') && !request()->is('leaves/*') ? 'active' : '' }}">Leaves (Admin)</a></li>
										<li><a href="{{ url('/leaves/employee') }}" class="{{ request()->is('leaves/employee') ? 'active' : '' }}">Leave (Employee)</a></li>
										<li><a href="{{ url('/leaves/settings') }}" class="{{ request()->is('leaves/settings') ? 'active' : '' }}">Leave Settings</a></li>												
									</ul>												
								</li>
								<li><a href="{{ url('/timesheets') }}" class="{{ request()->is('timesheets*') ? 'active' : '' }}">Timesheets</a></li>
								<li><a href="{{ url('/schedule') }}" class="{{ request()->is('schedule*') ? 'active' : '' }}">Shift & Schedule</a></li>
								<li><a href="{{ url('/overtime') }}" class="{{ request()->is('overtime*') ? 'active' : '' }}">Overtime</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/holidays') }}" class="{{ request()->is('holidays*') ? 'active' : '' }}">
								<i class="ti ti-calendar-event"></i><span>Holidays</span>
							</a>
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
							<a href="{{ route('promotions.index') }}" class="{{ request()->routeIs('promotions.*') ? 'active' : '' }}">
								<i class="ti ti-speakerphone"></i><span>Promotion</span>
							</a>
						</li>
						<li>
							<a href="{{ route('resignations.index') }}" class="{{ request()->routeIs('resignations.*') ? 'active' : '' }}">
								<i class="ti ti-external-link"></i><span>Resignation</span>
							</a>
						</li>
						<li>
							<a href="{{ route('terminations.index') }}" class="{{ request()->routeIs('terminations.*') ? 'active' : '' }}">
								<i class="ti ti-circle-x"></i><span>Termination</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Recruitment -->
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
						<li>
							<a href="{{ url('/referrals') }}" class="{{ request()->is('referrals*') ? 'active' : '' }}">
								<i class="ti ti-ux-circle"></i><span>Referrals</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Finance & Payroll -->
				<li class="menu-title"><span>FINANCE & PAYROLL</span></li>
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

				<!-- Documents & Support -->
				<li class="menu-title"><span>DOCUMENTS & SUPPORT</span></li>
				<li>
					<ul>
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
					</ul>
				</li>

				<!-- Assets & Resources -->
				<li class="menu-title"><span>ASSETS & RESOURCES</span></li>
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
					</ul>
				</li>

				<!-- Reports & Analytics -->
				<li class="menu-title"><span>REPORTS & ANALYTICS</span></li>
				<li>
					<ul>
						<li class="submenu {{ request()->is('reports*') ? 'active' : '' }}">
							<a href="javascript:void(0);" class="{{ request()->is('reports*') ? 'active subdrop' : '' }}">
								<i class="ti ti-chart-bar"></i><span>Reports</span>
								<span class="menu-arrow"></span>
							</a>
							<ul style="{{ request()->is('reports*') ? 'display: block;' : '' }}">
								<li><a href="{{ url('/reports/employees') }}" class="{{ request()->is('reports/employees') ? 'active' : '' }}">Employee Report</a></li>
								<li><a href="{{ url('/reports/attendance') }}" class="{{ request()->is('reports/attendance') ? 'active' : '' }}">Attendance Report</a></li>
								<li><a href="{{ url('/reports/leaves') }}" class="{{ request()->is('reports/leaves') ? 'active' : '' }}">Leave Report</a></li>
								<li><a href="{{ url('/reports/payslips') }}" class="{{ request()->is('reports/payslips') ? 'active' : '' }}">Payslip Report</a></li>
								<li><a href="{{ url('/reports/expenses') }}" class="{{ request()->is('reports/expenses') ? 'active' : '' }}">Expense Report</a></li>
								<li><a href="{{ url('/reports/training') }}" class="{{ request()->is('reports/training') ? 'active' : '' }}">Training Report</a></li>
								<li><a href="{{ url('/reports/recruitment') }}" class="{{ request()->is('reports/recruitment') ? 'active' : '' }}">Recruitment Report</a></li>
								<li><a href="{{ url('/reports/users') }}" class="{{ request()->is('reports/users') ? 'active' : '' }}">User Report</a></li>
								<li><a href="{{ url('/reports/daily') }}" class="{{ request()->is('reports/daily') ? 'active' : '' }}">Daily Report</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<!-- Settings -->
				<li class="menu-title"><span>SETTINGS</span></li>
				<li>
					<a href="{{ route('settings.index') }}" class="{{ request()->is('settings*') ? 'active' : '' }}">
						<i class="ti ti-settings"></i><span>Settings</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->
