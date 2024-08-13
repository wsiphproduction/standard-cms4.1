@php
	$footer = \App\Models\Page::where('slug', 'footer')->first();
@endphp


{!! $footer->contents !!}
<div style="position: fixed; z-index: 1000; width: 164px; height: 98px; bottom: 15px; left: 15px;">
<!--<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=kemc.com.ph','SiteLock','width=600,height=600,left=160,top=170');" ><img class="img-fluid" alt="SiteLock" title="SiteLock" src="https://shield.sitelock.com/shield/kemc.com.ph" /></a>--></div>


{{-- <!-- Cookie
============================================= -->
<div class="alert text-center cookiealert" role="alert">
	<strong>Do you like cookies?</strong> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="#" target="_blank">Learn more</a>
	<button type="button" class="btn btn-primary btn-sm acceptcookies px-3" aria-label="Close">
		I agree
	</button>
</div><!-- #cookie end --> --}}