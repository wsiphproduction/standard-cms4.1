<header id="header" class="border-bottom-0" data-sticky-shrink="false">
	<div id="header-wrap" style="border-bottom:3px solid #781049;">
		<div class="container">
			<div class="header-row">

				<!-- Logo
				============================================= -->
				<div id="logo">
					<a href="/" class="standard-logo" data-dark-logo="images/health-partners-logo.png"><img src="{{ Setting::get_company_logo_storage_path() }}" alt=""></a>
					<a href="/" class="retina-logo" data-dark-logo="images/health-partners-logo.png"><img src="{{ Setting::get_company_logo_storage_path() }}" alt=""></a>
				</div><!-- #logo end -->

				<div id="primary-menu-trigger">
					<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
				</div>

				<!-- Primary Navigation
				============================================= -->

				<nav class="primary-menu with-arrows">

				@include('theme.layouts.menu')

				</nav>

				<!-- #primary-menu end -->

			</div>
		</div>
	</div>
	<div class="header-wrap-clone"></div>
</header><!-- #header end -->

<!-- Header

============================================= -->
