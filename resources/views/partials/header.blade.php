<!-- Header -->
<style>
    .header {
        background: #ffffff !important;
        border-bottom: 1px solid #f0f0f0 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02) !important;
        height: 60px !important;
        z-index: 1002 !important;
    }

    .main-header {
        height: 60px !important;
        display: flex !important;
        align-items: center !important;
    }

    .header-user {
        flex: 1 !important;
        padding: 0 15px !important;
    }

    .user-menu.nav-list {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
    }

    /* Adjust page wrapper padding to match new slim header height */
    body:not(.login-page) .page-wrapper {
        padding-top: 60px !important;
    }

    /* Modern Search Bar */
    .header-search-wrapper {
        background: #f9fafb !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 5px 12px !important;
        width: 280px !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.2s ease !important;
        margin-left: 10px !important;
    }

    .header-search-wrapper:focus-within {
        background: #ffffff !important;
        border-color: #f26522 !important;
        box-shadow: 0 0 0 4px rgba(242, 101, 34, 0.1) !important;
    }

    .header-search-wrapper i {
        color: #9ca3af !important;
        font-size: 16px !important;
        margin-right: 10px !important;
    }

    .header-search-wrapper input {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        font-size: 13.5px !important;
        width: 100% !important;
        color: #111827 !important;
        outline: none !important;
    }

    .header-search-wrapper kbd {
        background: #ffffff !important;
        color: #9ca3af !important;
        border: 1px solid #e5e7eb !important;
        font-size: 10px !important;
        padding: 2px 6px !important;
        font-family: inherit !important;
        font-weight: 500 !important;
        margin-left: 10px !important;
    }

    /* Header Buttons */
    .btn-menubar {
        width: 40px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 10px !important;
        border: 1px solid #f0f0f0 !important;
        color: #4b5563 !important;
        background: #ffffff !important;
        transition: all 0.2s ease !important;
        margin-right: 10px !important;
    }

    .btn-menubar:hover {
        color: #f26522 !important;
        background: rgba(242, 101, 34, 0.05) !important;
        border-color: rgba(242, 101, 34, 0.2) !important;
        transform: translateY(-1px) !important;
    }

    .btn-menubar i {
        font-size: 20px !important;
    }

    .notification-status-dot {
        width: 8px !important;
        height: 8px !important;
        background: #ef4444 !important;
        border: 2px solid #ffffff !important;
        border-radius: 50% !important;
        position: absolute !important;
        top: 8px !important;
        right: 8px !important;
    }

    /* Profile Dropdown */
    .profile-dropdown .dropdown-toggle {
        padding: 2px !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        transition: all 0.2s ease !important;
    }

    .profile-dropdown .dropdown-toggle:hover {
        border-color: rgba(242, 101, 34, 0.2) !important;
    }

    .profile-dropdown .avatar {
        width: 40px !important;
        height: 40px !important;
    }

    .profile-dropdown .dropdown-menu {
        border: 1px solid #f0f0f0 !important;
        border-radius: 16px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08) !important;
        padding: 10px !important;
        min-width: 240px !important;
        margin-top: 10px !important;
    }

    .profile-dropdown .card {
        border: none !important;
    }

    .profile-dropdown .card-header {
        background: transparent !important;
        border-bottom: 1px solid #f5f5f5 !important;
        padding: 15px !important;
    }

    .profile-dropdown .dropdown-item {
        border-radius: 8px !important;
        padding: 10px 15px !important;
        font-weight: 500 !important;
        font-size: 14px !important;
        color: #4b5563 !important;
    }

    .profile-dropdown .dropdown-item:hover {
        background: rgba(242, 101, 34, 0.05) !important;
        color: #f26522 !important;
    }

    .profile-dropdown .dropdown-item i {
        font-size: 18px !important;
        margin-right: 10px !important;
    }

    /* Notification Dropdown */
    .notification-dropdown {
        width: 380px !important;
        border-radius: 16px !important;
        border: 1px solid #f0f0f0 !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08) !important;
        margin-top: 10px !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .notification-dropdown .border-bottom {
        padding: 20px !important;
        background: #f9fafb !important;
        border-bottom: 1px solid #f0f0f0 !important;
    }

    .notification-title {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #111827 !important;
        margin: 0 !important;
    }

    .noti-content {
        max-height: 350px !important;
        overflow-y: auto !important;
    }

    .notification-dropdown .noti-item {
        padding: 15px 20px !important;
        border-bottom: 1px solid #f5f5f5 !important;
        transition: all 0.2s ease !important;
        display: block !important;
        text-decoration: none !important;
    }

    .notification-dropdown .noti-item:hover {
        background: #f9fafb !important;
    }

    .notification-dropdown .noti-item:last-child {
        border-bottom: none !important;
    }

    .notification-dropdown .avatar {
        width: 40px !important;
        height: 40px !important;
        border-radius: 10px !important;
    }

    .notification-dropdown .btn-light {
        background: #f3f4f6 !important;
        border: none !important;
        font-weight: 600 !important;
        font-size: 13px !important;
    }

    .notification-dropdown .btn-primary {
        background: #f26522 !important;
        border: none !important;
        font-weight: 600 !important;
        font-size: 13px !important;
    }

    .notification-dropdown .noti-footer {
        padding: 15px 20px !important;
        background: #ffffff !important;
        border-top: 1px solid #f0f0f0 !important;
        display: flex !important;
        gap: 10px !important;
    }

    /* Scrollbar for notifications */
    .noti-content::-webkit-scrollbar {
        width: 5px;
    }
    .noti-content::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
</style>

<div class="header">
	<div class="main-header">

		<a id="mobile_btn" class="mobile_btn" href="#sidebar">
			<span class="bar-icon">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</a>

		<div class="header-user">
			<div class="nav user-menu nav-list">

				<div class="me-auto d-flex align-items-center" id="header-search">
					<a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar">
						<i class="ti ti-arrow-bar-to-left"></i>
					</a>
					<!-- Search -->
					<div class="header-search-wrapper">
						<i class="ti ti-search"></i>
						<input type="text" placeholder="Search anything...">
						<kbd class="d-none d-md-inline-block">CTRL + /</kbd>
					</div>
					<!-- /Search -->
				</div>


				<div class="d-flex align-items-center">
					<div class="me-1">
						<a href="#" class="btn btn-menubar btnFullscreen">
							<i class="ti ti-maximize"></i>
						</a>
					</div>
					<div class="me-1 notification_item">
						<a href="#" class="btn btn-menubar position-relative me-1" id="notification_popup"
							data-bs-toggle="dropdown">
							<i class="ti ti-bell"></i>
							<span class="notification-status-dot"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-end notification-dropdown">
							<div class="d-flex align-items-center justify-content-between border-bottom">
								<h4 class="notification-title">Notifications (2)</h4>
								<div class="d-flex align-items-center">
									<a href="#" class="text-primary fs-13 me-3">Mark all as read</a>
								</div>
							</div>
							<div class="noti-content">
								<div class="d-flex flex-column">
									<a href="{{ url('/activity') }}" class="noti-item">
										<div class="d-flex">
											<span class="avatar me-3">
												<img src="{{ asset('assets/img/profiles/avatar-27.jpg') }}" alt="Profile" class="rounded-circle">
											</span>
											<div class="flex-grow-1">
												<p class="mb-1 text-dark"><span class="fw-semibold">Shawn</span> performance in Math is below threshold.</p>
												<span class="fs-12 text-muted"><i class="ti ti-clock me-1"></i>Just Now</span>
											</div>
										</div>
									</a>
									<a href="{{ url('/activity') }}" class="noti-item">
										<div class="d-flex">
											<span class="avatar me-3">
												<img src="{{ asset('assets/img/profiles/avatar-23.jpg') }}" alt="Profile" class="rounded-circle">
											</span>
											<div class="flex-grow-1">
												<p class="mb-1 text-dark"><span class="fw-semibold">Sylvia</span> added appointment on 02:00 PM</p>
												<span class="fs-12 text-muted"><i class="ti ti-clock me-1"></i>10 mins ago</span>
												<div class="d-flex justify-content-start align-items-center mt-2">
													<span class="btn btn-light btn-sm me-2 py-1">Deny</span>
													<span class="btn btn-primary btn-sm py-1">Approve</span>
												</div>
											</div>
										</div>
									</a>
									<a href="{{ url('/activity') }}" class="noti-item">
										<div class="d-flex">
											<span class="avatar me-3">
												<img src="{{ asset('assets/img/profiles/avatar-25.jpg') }}" alt="Profile" class="rounded-circle">
											</span>
											<div class="flex-grow-1">
												<p class="mb-1 text-dark">New student record <span class="fw-semibold"> George</span> is created by <span class="fw-semibold">Teressa</span></p>
												<span class="fs-12 text-muted"><i class="ti ti-clock me-1"></i>2 hrs ago</span>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="noti-footer">
								<a href="#" class="btn btn-light w-100">Cancel</a>
								<a href="{{ url('/activity') }}" class="btn btn-primary w-100">View All</a>
							</div>
						</div>
					</div>
					<div class="dropdown profile-dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
							data-bs-toggle="dropdown">
							<span class="avatar avatar-sm online">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Img" class="img-fluid rounded-circle">
                                @else
								    <img src="{{ asset('assets/img/profiles/avatar-12.jpg') }}" alt="Img" class="img-fluid rounded-circle">
                                @endif
							</span>
						</a>
						<div class="dropdown-menu">
							<div class="card mb-0">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<span class="avatar avatar-lg me-2 avatar-rounded">
                                            @if(Auth::user()->profile_picture)
                                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="img">
                                            @else
											    <img src="{{ asset('assets/img/profiles/avatar-12.jpg') }}" alt="img">
                                            @endif
										</span>
										<div>
											<h5 class="mb-0 text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</h5>
											<p class="fs-12 fw-medium mb-0 text-muted">{{ Auth::user()->email }}</p>
										</div>
									</div>
								</div>
								<div class="card-body">
									<a class="dropdown-item d-inline-flex align-items-center" href="{{ url('/profile') }}">
										<i class="ti ti-user-circle"></i>My Profile
									</a>
									<a class="dropdown-item d-inline-flex align-items-center" href="{{ url('/settings') }}">
										<i class="ti ti-settings"></i>Settings
									</a>
								</div>
								<div class="card-footer">
									<form method="POST" action="{{ route('logout') }}">
										@csrf
										<button type="submit" class="dropdown-item d-inline-flex align-items-center w-100 border-0 bg-transparent text-start">
											<i class="ti ti-logout me-2"></i>Logout
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Mobile Menu -->
		<div class="dropdown mobile-user-menu">
			<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
			<div class="dropdown-menu dropdown-menu-end">
				<a class="dropdown-item" href="{{ url('/profile') }}">My Profile</a>
				<a class="dropdown-item" href="{{ url('/settings') }}">Settings</a>
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="dropdown-item w-100 border-0 bg-transparent text-start">Logout</button>
				</form>
			</div>
		</div>
		<!-- /Mobile Menu -->

	</div>

</div>
<!-- /Header -->
