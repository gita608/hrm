<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<!-- Logo -->
	<div class="sidebar-logo d-flex flex-column align-items-center justify-content-end">
		<a href="{{ route('dashboard') }}" class="logo logo-normal d-flex flex-column align-items-center justify-content-end text-decoration-none w-100" aria-label="{{ \App\Helpers\SettingsHelper::appName() }} Home">
			@if(\App\Helpers\SettingsHelper::appLogo())
				<img src="{{ \App\Helpers\SettingsHelper::appLogo() }}" 
					 alt="{{ \App\Helpers\SettingsHelper::appName() }}"
					 class="sidebar-logo-img"
					 style="object-fit: contain; display: block; vertical-align: bottom;">
			@else
				<span class="fw-bold fs-18">{{ \App\Helpers\SettingsHelper::appName() }}</span>
			@endif
		</a>
	</div>

	<div class="sidebar-header p-3 pb-0 pt-2">
		<div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
			<div class="avatar avatar-md onlin">
				<img src="{{ asset('assets/img/profiles/avatar-02.jpg') }}" alt="User Avatar" class="img-fluid rounded-circle">
			</div>
			<div class="text-start sidebar-profile-info ms-2">
				<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
				<p class="fs-10">System Admin</p>
			</div>
		</div>
		<div class="input-group input-group-flat d-inline-flex mb-4">
			<span class="input-icon-addon">
				<i class="ti ti-search" aria-hidden="true"></i>
			</span>
			<input type="text" class="form-control" placeholder="Search in HRMS" aria-label="Search in HRMS">
			<span class="input-group-text">
				<kbd>CTRL + /</kbd>
			</span>
		</div>
		<div class="d-flex align-items-center justify-content-between menu-item mb-3" role="toolbar" aria-label="Quick actions">
			<a href="javascript:void(0);" class="btn btn-menubar me-3" aria-label="Calendar" title="Calendar">
				<i class="ti ti-layout-grid-remove" aria-hidden="true"></i>
			</a>
			<a href="javascript:void(0);" class="btn btn-menubar position-relative me-3" aria-label="Chat" title="Chat">
				<i class="ti ti-brand-hipchat" aria-hidden="true"></i>
				<span class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge" aria-label="5 unread messages">5</span>
			</a>
			<a href="javascript:void(0);" class="btn btn-menubar position-relative me-3 notification-item" aria-label="Notifications" title="Notifications">
				<i class="ti ti-bell" aria-hidden="true"></i>
				<span class="notification-status-dot" aria-hidden="true"></span>
			</a>
			<a href="javascript:void(0);" class="btn btn-menubar" aria-label="Email" title="Email">
				<i class="ti ti-message" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	
	<div class="sidebar-inner slimscroll">
		<nav id="sidebar-menu" class="sidebar-menu" aria-label="Main navigation">
			<ul>
				@php
					// Helper function to check if route is active
					$isActive = function($patterns) {
						foreach ((array)$patterns as $pattern) {
							if (request()->is($pattern) || request()->routeIs($pattern)) {
								return true;
							}
						}
						return false;
					};
					
					// Helper function to get active class
					$activeClass = function($patterns) use ($isActive) {
						return $isActive($patterns) ? 'active' : '';
					};
					
					// Helper function to get submenu active class
					$submenuActiveClass = function($patterns) use ($isActive) {
						return $isActive($patterns) ? 'active' : '';
					};
					
					// Helper function to get subdrop class
					$subdropClass = function($patterns) use ($isActive) {
						return $isActive($patterns) ? 'active subdrop' : '';
					};
					
					// Helper function to get display style
					$displayStyle = function($patterns) use ($isActive) {
						return $isActive($patterns) ? 'display: block;' : '';
					};
				@endphp

				<!-- Dashboard -->
				<li class="menu-title"><span>DASHBOARD</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ route('dashboard') }}" class="{{ $activeClass('dashboard') }}">
								<i class="ti ti-layout-dashboard" aria-hidden="true"></i><span>Dashboard</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Organization Structure -->
				<li class="menu-title"><span>ORGANIZATION</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ route('departments.index') }}" class="{{ $activeClass('departments.*') }}">
								<i class="ti ti-building" aria-hidden="true"></i><span>Departments</span>
							</a>
						</li>
						<li>
							<a href="{{ route('designations.index') }}" class="{{ $activeClass('designations.*') }}">
								<i class="ti ti-briefcase" aria-hidden="true"></i><span>Designations</span>
							</a>
						</li>
						<li class="submenu {{ $submenuActiveClass(['users*', 'roles*']) }}">
							<a href="javascript:void(0);" class="{{ $subdropClass(['users*', 'roles*']) }}" aria-expanded="{{ $isActive(['users*', 'roles*']) ? 'true' : 'false' }}">
								<i class="ti ti-user-star" aria-hidden="true"></i><span>User Management</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle(['users*', 'roles*']) }}">
								<li><a href="{{ route('users.index') }}" class="{{ $activeClass('users*') }}">Users</a></li>
								<li><a href="{{ route('roles.index') }}" class="{{ $activeClass('roles*') }}">Roles & Permissions</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<!-- Employee Management -->
				<li class="menu-title"><span>EMPLOYEE MANAGEMENT</span></li>
				<li>
					<ul>
						<li class="submenu {{ $submenuActiveClass('attendance*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('attendance*') }}" aria-expanded="{{ $isActive('attendance*') ? 'true' : 'false' }}">
								<i class="ti ti-file-time" aria-hidden="true"></i><span>Attendance</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('attendance*') }}">
								<li><a href="{{ route('attendance.admin') }}" class="{{ $activeClass('attendance/admin') }}">Attendance (Admin)</a></li>
								<li><a href="{{ route('attendance.employee') }}" class="{{ $activeClass('attendance/employee') }}">Attendance (Employee)</a></li>
							</ul>
						</li>
						<li class="submenu {{ $submenuActiveClass('leaves*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('leaves*') }}" aria-expanded="{{ $isActive('leaves*') ? 'true' : 'false' }}">
								<i class="ti ti-calendar-off" aria-hidden="true"></i><span>Leaves</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('leaves*') }}">
								<li><a href="{{ route('leaves.index') }}" class="{{ $activeClass('leaves') && !request()->is('leaves/*') ? 'active' : '' }}">Leaves (Admin)</a></li>
								<li><a href="{{ route('leaves.employee') }}" class="{{ $activeClass('leaves/employee') }}">Leave (Employee)</a></li>
								<li><a href="{{ route('leaves.settings') }}" class="{{ $activeClass('leaves/settings') }}">Leave Settings</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ url('/timesheets') }}" class="{{ $activeClass('timesheets*') }}">
								<i class="ti ti-clock" aria-hidden="true"></i><span>Timesheets</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/schedule') }}" class="{{ $activeClass('schedule*') }}">
								<i class="ti ti-calendar-time" aria-hidden="true"></i><span>Shift & Schedule</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/overtime') }}" class="{{ $activeClass('overtime*') }}">
								<i class="ti ti-clock-hour-4" aria-hidden="true"></i><span>Overtime</span>
							</a>
						</li>
						<li>
							<a href="{{ route('holidays.index') }}" class="{{ $activeClass('holidays*') }}">
								<i class="ti ti-calendar-event" aria-hidden="true"></i><span>Holidays</span>
							</a>
						</li>
						<li class="submenu {{ $submenuActiveClass(['training*', 'trainers*']) }}">
							<a href="javascript:void(0);" class="{{ $subdropClass(['training*', 'trainers*']) }}" aria-expanded="{{ $isActive(['training*', 'trainers*']) ? 'true' : 'false' }}">
								<i class="ti ti-edit" aria-hidden="true"></i><span>Training</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle(['training*', 'trainers*']) }}">
								<li><a href="{{ route('training.index') }}" class="{{ $activeClass('training') && !request()->is('training/*') ? 'active' : '' }}">Training List</a></li>
								<li><a href="{{ route('trainers.index') }}" class="{{ $activeClass('trainers*') }}">Trainers</a></li>
								<li><a href="{{ route('training.types.index') }}" class="{{ $activeClass('training/types') }}">Training Type</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ route('promotions.index') }}" class="{{ $activeClass('promotions.*') }}">
								<i class="ti ti-speakerphone" aria-hidden="true"></i><span>Promotion</span>
							</a>
						</li>
						<li>
							<a href="{{ route('resignations.index') }}" class="{{ $activeClass('resignations.*') }}">
								<i class="ti ti-external-link" aria-hidden="true"></i><span>Resignation</span>
							</a>
						</li>
						<li>
							<a href="{{ route('terminations.index') }}" class="{{ $activeClass('terminations.*') }}">
								<i class="ti ti-circle-x" aria-hidden="true"></i><span>Termination</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Recruitment -->
				<li class="menu-title"><span>RECRUITMENT</span></li>
				<li>
					<ul>
						<li>
							<a href="{{ route('jobs.index') }}" class="{{ $activeClass('jobs*') }}">
								<i class="ti ti-timeline" aria-hidden="true"></i><span>Jobs</span>
							</a>
						</li>
						<li>
							<a href="{{ route('candidates.index') }}" class="{{ $activeClass('candidates*') }}">
								<i class="ti ti-user-shield" aria-hidden="true"></i><span>Candidates</span>
							</a>
						</li>
						<li class="submenu {{ $submenuActiveClass('interviews*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('interviews*') }}" aria-expanded="{{ $isActive('interviews*') ? 'true' : 'false' }}">
								<i class="ti ti-calendar-check" aria-hidden="true"></i><span>Interview</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('interviews*') }}">
								<li><a href="{{ route('interviews.index') }}" class="{{ $activeClass('interviews') && !request()->is('interviews/*') ? 'active' : '' }}">Interview Schedule</a></li>
								<li><a href="{{ route('interviews.feedback.index') }}" class="{{ $activeClass('interviews/feedback') }}">Interview Feedback</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ route('referrals.index') }}" class="{{ $activeClass('referrals*') }}">
								<i class="ti ti-ux-circle" aria-hidden="true"></i><span>Referrals</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Finance & Payroll -->
				<li class="menu-title"><span>FINANCE & PAYROLL</span></li>
				<li>
					<ul>
						<li class="submenu {{ $submenuActiveClass(['payroll*', 'provident-fund*', 'taxes*']) }}">
							<a href="javascript:void(0);" class="{{ $subdropClass(['payroll*', 'provident-fund*', 'taxes*']) }}" aria-expanded="{{ $isActive(['payroll*', 'provident-fund*', 'taxes*']) ? 'true' : 'false' }}">
								<i class="ti ti-cash" aria-hidden="true"></i><span>Payroll</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle(['payroll*', 'provident-fund*', 'taxes*']) }}">
								<li><a href="javascript:void(0);" class="{{ $activeClass('payroll/salary') }}">Employee Salary</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('payroll/payslip') }}">Payslip</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('payroll/items') }}">Payroll Items</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('provident-fund*') }}">Provident Fund</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('taxes*') }}">Taxes</a></li>
							</ul>
						</li>
						<li class="submenu {{ $submenuActiveClass(['expenses*', 'categories*', 'budgets*', 'budget-expenses*', 'budget-revenues*']) }}">
							<a href="javascript:void(0);" class="{{ $subdropClass(['expenses*', 'categories*', 'budgets*', 'budget-expenses*', 'budget-revenues*']) }}" aria-expanded="{{ $isActive(['expenses*', 'categories*', 'budgets*', 'budget-expenses*', 'budget-revenues*']) ? 'true' : 'false' }}">
								<i class="ti ti-file-dollar" aria-hidden="true"></i><span>Accounting</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle(['expenses*', 'categories*', 'budgets*', 'budget-expenses*', 'budget-revenues*']) }}">
								<li><a href="javascript:void(0);" class="{{ $activeClass('expenses*') }}">Expenses</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('categories*') }}">Categories</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('budgets') && !request()->is('budgets/*') ? 'active' : '' }}">Budgets</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('budget-expenses*') }}">Budget Expenses</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('budget-revenues*') }}">Budget Revenues</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<!-- Documents & Support -->
				<li class="menu-title"><span>DOCUMENTS & SUPPORT</span></li>
				<li>
					<ul>
						<li class="submenu {{ $submenuActiveClass('documents*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('documents*') }}" aria-expanded="{{ $isActive('documents*') ? 'true' : 'false' }}">
								<i class="ti ti-file-text" aria-hidden="true"></i><span>Documents</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('documents*') }}">
								<li><a href="javascript:void(0);" class="{{ $activeClass('documents') && !request()->is('documents/*') ? 'active' : '' }}">Document Library</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('documents/letters') }}">HR Letters</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('documents/certificates') }}">Certificates</a></li>
							</ul>
						</li>
						<li class="submenu {{ $submenuActiveClass('tickets*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('tickets*') }}" aria-expanded="{{ $isActive('tickets*') ? 'true' : 'false' }}">
								<i class="ti ti-ticket" aria-hidden="true"></i><span>Tickets</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('tickets*') }}">
								<li><a href="javascript:void(0);" class="{{ $activeClass('tickets') && !request()->is('tickets/*') ? 'active' : '' }}">Tickets</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('tickets/details') }}">Ticket Details</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<!-- Assets & Resources -->
				<li class="menu-title"><span>ASSETS & RESOURCES</span></li>
				<li>
					<ul>
						<li class="submenu {{ $submenuActiveClass('assets*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('assets*') }}" aria-expanded="{{ $isActive('assets*') ? 'true' : 'false' }}">
								<i class="ti ti-package" aria-hidden="true"></i><span>Assets</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('assets*') }}">
								<li><a href="{{ route('assets.index') }}" class="{{ $activeClass('assets') && !request()->is('assets/*') ? 'active' : '' }}">Assets</a></li>
								<li><a href="{{ route('assets.categories.index') }}" class="{{ $activeClass('assets/categories') }}">Asset Categories</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<!-- Reports & Analytics -->
				<li class="menu-title"><span>REPORTS & ANALYTICS</span></li>
				<li>
					<ul>
						<li class="submenu {{ $submenuActiveClass('reports*') }}">
							<a href="javascript:void(0);" class="{{ $subdropClass('reports*') }}" aria-expanded="{{ $isActive('reports*') ? 'true' : 'false' }}">
								<i class="ti ti-chart-bar" aria-hidden="true"></i><span>Reports</span>
								<span class="menu-arrow" aria-hidden="true"></span>
							</a>
							<ul style="{{ $displayStyle('reports*') }}">
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/employees') }}">Employee Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/attendance') }}">Attendance Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/leaves') }}">Leave Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/payslips') }}">Payslip Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/expenses') }}">Expense Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/training') }}">Training Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/recruitment') }}">Recruitment Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/users') }}">User Report</a></li>
								<li><a href="javascript:void(0);" class="{{ $activeClass('reports/daily') }}">Daily Report</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<!-- Settings -->
				<li class="menu-title"><span>SETTINGS</span></li>
				<li>
					<a href="{{ route('settings.index') }}" class="{{ $activeClass('settings*') }}">
						<i class="ti ti-settings" aria-hidden="true"></i><span>Settings</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<!-- /Sidebar -->
