@if (Auth::guard('web')->check())
	<p class="text-success">
		You are are  logged in a user!
	</p>
@else
	<p class="text-danger">
		You are are  logged out a user!
	</p>
@endif

@if (Auth::guard('admin')->check())
	<p class="text-success">
		You are are  logged in a admin!
	</p>
@else
	<p class="text-danger">
		You are are  logged out a admin!
	</p>
@endif