@extends('template')

@section('pressed-login')
	active
@stop

	

@section('content')
<div class="row sign_up_today">
<div class="col-lg-12">
<div class="container text-center login_credential">

		{{ Form::open(
			array(	'url' 	=> 	'/user/signin',
					'autocomplete' => 'off'
			)) 
		}}
<p>
					{{ Form::text(	
						'email', 
						'', 
						array(
							'placeholder'=> 'Email', 
							'maxlength'	 => '100',
							'id' => 'login',
							'class' => 'form-control login_credential'
							
						)) 
					}}<br />
					{{ $errors->first('email') }}
					@if( isset($failmessage) ) 
						{{ $failmessage }}
					@endif
					<br />
					{{ Form::password(	
						'password',
						array(	
							'placeholder'=> 'Password',
							'maxlength'	 => '20',
							'id' => 'login',
							'class' => 'form-control login_credential'
						)) 
					}}<br />
					{{ $errors->first('password') }}
</p>

					<?php /*<label class="checkbox">
						<input type="checkbox"> Remember me
					</label> */ ?>
					


					<button class="btn btn-default signin" type="submit">Sign In</button>


					<a href="user/signup">
					<button class="btn btn-default" type="button">Register</button>
					</a>


						{{ Form::close() }}
					

					
					<button class="btn btn-default btn-xs fb_signin" type="button"><img style="margin-right:5px;" src="/assets/img/icon_fb.png" />Sign in with Facebook</button>
					
					<br />
					

		

</div>
</div>

<?php /*
<div class="col-lg-8">
<link href='http://fonts.googleapis.com/css?family=Coming+Soon' rel='stylesheet' type='text/css'>
<div class="sign_up">
Sign up today <br /> <br />Story Line is always free for you!
</div>
<img class="sign_up" src="/assets/img/arrow.png" />
</div> */ ?>


</div>

@stop