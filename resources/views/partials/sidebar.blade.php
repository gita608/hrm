<!-- Sidebar -->
<style>
    /* Modern Sidebar Overrides */
    #sidebar.sidebar {
        background: #ffffff !important;
        border-right: 1px solid #f0f0f0 !important;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.03) !important;
    }

    #sidebar .sidebar-top {
        padding: 25px 15px 10px !important;
        background: #ffffff !important;
        text-align: center;
    }

    #sidebar .sidebar-logo {
        height: auto !important;
        min-height: auto !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: transparent !important;
        border: none !important;
    }

    #sidebar .sidebar-logo-img {
        max-height: 55px !important;
        width: auto !important;
        height: auto !important;
        transition: transform 0.3s ease;
    }

    #sidebar .sidebar-logo-img:hover {
        transform: scale(1.05);
    }

    /* Remove existing padding from sidebar elements to fix alignment */
    #sidebar .slimScrollDiv {
        padding: 0 !important;
    }

    #sidebar .sidebar-menu {
        padding: 5px 0 !important;
    }

    #sidebar .sidebar-menu ul li a {
        margin: 2px 12px !important;
        padding: 10px 14px !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
        color: #4b5563 !important;
        font-weight: 500 !important;
        font-size: 13.5px !important;
        text-decoration: none !important;
    }

    #sidebar .sidebar-menu ul li a i {
        font-size: 16px !important;
        margin-right: 10px !important;
        width: 20px !important;
        text-align: center !important;
    }

    #sidebar .sidebar-menu ul li a:hover {
        background: rgba(242, 101, 34, 0.04) !important;
        color: #f26522 !important;
    }

    /* Parent Active State (Top Level) */
    #sidebar .sidebar-menu > ul > li > a.active {
        background: #f26522 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(242, 101, 34, 0.2) !important;
    }

    #sidebar .sidebar-menu > ul > li > a.active i {
        color: #ffffff !important;
    }

    /* Submenu Parent Active State (When child is active) */
    #sidebar .sidebar-menu > ul > li.submenu.active > a {
        background: rgba(242, 101, 34, 0.08) !important;
        color: #f26522 !important;
        box-shadow: none !important;
    }

    #sidebar .sidebar-menu > ul > li.submenu.active > a i {
        color: #f26522 !important;
    }

    /* Child Menu Items */
    #sidebar .sidebar-menu ul ul {
        background: transparent !important;
        margin: 5px 0 !important;
        padding: 0 !important;
    }

    #sidebar .sidebar-menu ul ul li a {
        padding: 8px 14px 8px 48px !important;
        font-size: 13px !important;
        margin: 1px 12px !important;
        color: #6b7280 !important;
        background: transparent !important;
        position: relative !important;
    }

    /* Active Child Item */
    #sidebar .sidebar-menu ul ul li a.active {
        color: #f26522 !important;
        font-weight: 600 !important;
        background: rgba(242, 101, 34, 0.04) !important;
    }

    #sidebar .sidebar-menu ul ul li a.active::before {
        content: "";
        position: absolute;
        left: 28px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background: #f26522;
        border-radius: 50%;
    }

    #sidebar .sidebar-menu ul ul li a i {
        display: none !important; /* Keep sub-menu clean */
    }

    #sidebar .menu-title {
        padding: 10px 25px 8px !important;
        color: #9ca3af !important;
        font-size: 10.5px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        font-weight: 600 !important;
    }

    #sidebar .menu-arrow {
        margin-left: auto !important;
        font-size: 10px !important;
        transition: transform 0.2s !important;
    }

    #sidebar .subdrop .menu-arrow {
        transform: rotate(90deg) !important;
    }

    #sidebar .notification-status-dot {
        border-radius: 50%;
        position: absolute;
        top: 8px;
        right: 12px;
    }
</style>

<div class="sidebar" id="sidebar">
	<div class="sidebar-top">
		<!-- Logo -->
		<div class="sidebar-logo">
			<a href="{{ route('dashboard') }}" class="logo d-flex align-items-center justify-content-center text-decoration-none w-100">
				@if(\App\Helpers\SettingsHelper::appLogo())
					<img src="{{ \App\Helpers\SettingsHelper::appLogo() }}" 
						 alt="{{ \App\Helpers\SettingsHelper::appName() }}"
						 class="sidebar-logo-img">
				@endif
			</a>
		</div>
	</div>
	
	<div class="sidebar-inner slimscroll">
		<nav id="sidebar-menu" class="sidebar-menu">
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
										<i class="{{ $menuItem->icon }}"></i>
									@endif
									<span>{{ $menuItem->name }}</span>
									<span class="menu-arrow ti ti-chevron-right"></span>
								</a>
								<ul style="{{ $displayStyle($menuItem) }}">
									@foreach($menuItem->children as $child)
										<li>
											<a href="{{ $child->url ?? route($child->route) }}" class="{{ $activeClass($child) }}">
												@if($child->icon)
													<i class="{{ $child->icon }}"></i>
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
										<i class="{{ $menuItem->icon }}"></i>
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
