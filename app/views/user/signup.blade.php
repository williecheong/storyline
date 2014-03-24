@extends('template')

@section('pressed-login')
	active
@endsection

@section('content')
	<div class="container text-center registration">
		{{ Form::open(
			array(	'class'	=>	'form-horizontal', 
					'url' 	=> 	'user/signup',
					'autocomplete' => 'off'
			)) 
		}}
			<div class="control-group">

				<div class="controls">
					{{ Form::text(	
						'display_name',
						'',
						array(	
							'placeholder'=> 'Display Name',
							'maxlength'	 => '20',
							'class' => 'form-control registration'
						)) 
					}}<br />
					{{ $errors->first('display_name') }}
				</div>
			</div>
			<br>
			<div class="control-group">

				<div class="controls">
					{{ Form::text(	
						'email', 
						'', 
						array(
							'placeholder'=> 'Email', 
							'maxlength'	 => '100',
							'class' => 'form-control registration'
						)) 
					}}<br />
					{{ $errors->first('email') }}
				</div>
			</div>
			<div class="control-group">

				<div class="controls">
					{{ Form::text(	
						'c_email', 
						'', 
						array(
							'placeholder'=> 'Confrim Email', 
							'maxlength'	 => '100',
							'class' => 'form-control registration'
						)) 
					}}<br />
					{{ $errors->first('c_email') }}
				</div>
			</div>
			<br>
			<div class="control-group">

				<div class="controls">
					{{ Form::password(	
						'password',
						array(	
							'placeholder'=> 'Password',
							'maxlength'	 => '20',
							'class' => 'form-control registration'
						)) 
					}}<br />
					{{ $errors->first('password') }}
				</div>
			</div>
			<div class="control-group">

				<div class="controls">
					{{ Form::password(	
						'c_password',
						array(	
							'placeholder'=> 'Confrim Password',
							'maxlength'	 => '20',
							'class' => 'form-control registration'
						)) 
					}}<br />
					{{ $errors->first('c_password') }}
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-default reg_submit">Submit</button>
					{{ Form::close() }}
					<a href=".."><button type="button" class="btn btn-default reg_submit">Cancel</button></a>
				</div>
			</div>

	</div>
@endsection
