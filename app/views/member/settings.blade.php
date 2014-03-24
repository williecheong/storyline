@extends('template')

@section('content')
	<?php /*<h3>Hi, {{ Auth::user()->display }} </h3><br />
	<h4>You may change your account setting here </h4><br /> */ ?>
	<div class="text-center">
		<button type="button" class="btn btn-primary request-change-password">
			<h6>Change my Password</h6>
		</button>
	</div>
	
	<div class="change-password text-center">
		<div class="settings"></div>
		<?php //<input class="form-control old_password" type="password" placeholder="Current Password" /> <br /> ?>
		<input class="form-control password" type="password" placeholder="New Password" /> <br />
		<input class="form-control confirm_password" type="password" placeholder="Confirm New Password" /> <br />
		<button class="btn btn-default member-settings" type="button">
			Submit
		</button>
	</div>

@stop

@section('custom-js')
	<script src="/assets/js/member-settings.js"></script>
@stop