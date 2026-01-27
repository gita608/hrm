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
					// Helper function to check if menu item is active
					$isActive = function($item) {
						if (!$item) return false;

						// Check Route
						if (!empty($item->route)) {
							// Check for exact route match or wildcard match
							if (request()->routeIs($item->route) || request()->routeIs($item->route . '*')) {
								return true;
							}
						}

						// Check URL
						if (!empty($item->url) && $item->url !== '#') {
							// Determine path for checking
							$path = trim($item->url, '/');
							if (request()->is($path) || request()->is($path . '/*')) {
								return true;
							}
						}
						
						return false;
					};
					
					// Helper function to get active class
					$activeClass = function($item) use ($isActive) {
						return $isActive($item) ? 'active' : '';
					};

                    // Helper to check if a parent menu should be active (by checking children)
                    $isParentActive = function($menuItem) use ($isActive) {
                         // If parent itself is active
                        if ($isActive($menuItem)) {
                            return true;
                        }
                        
                        // Check children
                        foreach ($menuItem->children as $child) {
                             if ($isActive($child)) {
                                return true;
                             }
                        }
                        return false;
                    };
					
					// Helper function to get submenu active class
					$submenuActiveClass = function($menuItem) use ($isParentActive) {
						return $isParentActive($menuItem) ? 'active' : '';
					};
					
					// Helper function to get subdrop class
					$subdropClass = function($menuItem) use ($isParentActive) {
						return $isParentActive($menuItem) ? 'active subdrop' : '';
					};
					
					// Helper function to get display style
					$displayStyle = function($menuItem) use ($isParentActive) {
						return $isParentActive($menuItem) ? 'display: block;' : 'display: none;';
					};

					// Get menu items from the database
					$menuItems = app(\App\Http\Controllers\MenuItemController::class)->getMenu();
				@endphp

				@foreach($menuItems as $menuItem)
					@if($menuItem->type === 'title')
						<li class="menu-title"><span>{{ $menuItem->name }}</span></li>
					@endif

					@if($menuItem->type === 'item' || empty($menuItem->type))
						@if($menuItem->children->count() > 0)
							<li class="submenu {{ $submenuActiveClass($menuItem) }}">
								<a href="javascript:void(0);" class="{{ $subdropClass($menuItem) }}">
									@if($menuItem->icon)
										<i class="{{ $menuItem->icon }}" aria-hidden="true"></i>
									@endif
									<span>{{ $menuItem->name }}</span>
									<span class="menu-arrow" aria-hidden="true"></span>
								</a>
								<ul style="{{ $displayStyle($menuItem) }}">
									@foreach($menuItem->children as $child)
										<li>
											<a href="{{ $child->url ?? route($child->route) }}" class="{{ $activeClass($child) }}">
												@if($child->icon)
													<i class="{{ $child->icon }}" aria-hidden="true"></i>
												@endif
												<span>{{ $child->name }}</span>
											</a>
										</li>
									@endforeach
								</ul>
							</li>
						@else
							<li>
								<a href="{{ $menuItem->url ?? route($menuItem->route) }}" class="{{ $activeClass($menuItem) }}">
									@if($menuItem->icon)
										<i class="{{ $menuItem->icon }}" aria-hidden="true"></i>
									@endif
									<span>{{ $menuItem->name }}</span>
								</a>
							</li>
						@endif
					@endif
				@endforeach


			</ul>
		</nav>
	</div>
</div>
<!-- /Sidebar -->
