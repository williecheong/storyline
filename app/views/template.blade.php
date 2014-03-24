<!doctype html>

<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>StoryLine</title>
	<link rel="shortcut icon" href="/assets/img/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- CSS ESSENTIALS-->
	<link href="/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" >
	<link href="/assets/css/bootstrap_overwrite.css" rel="stylesheet" >
	<link href="/assets/css/style.css" rel="stylesheet" type="text/css">
	<link href="/assets/plugins/bootstrap/css/bootstrap-glyphicons.css" rel="stylesheet" >
	

	<!-- Third party CSS plugins -->
	<link href="/assets/plugins/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css">
	{{-- Todo: Replace with local copy for independency --}}
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,700' rel='stylesheet' type='text/css' />
	
</head>

<body>
	<header class="row">
		<div class="col-lg-6 text-center sl-logo">
			<a href="{{ Request::root() }}" style="display:inline-block;"><img class="img-responsive" src="/assets/img/logo.png" /></a>
		</div>
		<div class="col-lg-6 text-right sl-user">
			@if( Auth::check() ) 
				Welcome, {{ Auth::user()->display }}
				<a href="/member/settings"><span class="glyphicon glyphicon-cog"></span></a>
			@endif

			<div>
				<div class="nav nav-pills pull-right sl-nav">
					<?php /*
					<li class="@yield('pressed-about')">
						<a href="#"><i class="icon-info-sign"></i> About</a>
					</li>
					*/ ?>
					<li class="@yield('pressed-stories')">
						<a href="/read"><span class="glyphicon glyphicon-book"></span> Stories</a>
					</li>
					@if( Auth::check() ) 
					<li class="@yield('pressed-manage')">
						<a href="/member/mystories"><span class="glyphicon glyphicon-globe"></span> Manage</a>
					</li>
					<li>
						<a href="/user/signout"><span class="glyphicon glyphicon-remove-circle"></span> Logout</a>
					</li>
					@else
					<li class="@yield('pressed-login')">
						<a href="/user"><span class="glyphicon glyphicon-user"></span> Login / Sign Up</a>
					</li>
					@endif
				</div>
			</div>
		</div>
	</header>
		
	<section class="container">
		<div class="middle" style="margin-top:50px;">
			@yield('content')
		</div>
	</section>
		
	<footer class="text-center sl-footer">
		<div class="bottom" style="margin-top:50px;">
			<h6 class="footer">&copy; Copyright {{ date('Y') }}</h6>
			<button class="show-buggy btn btn-default btn-xs"><span class="glyphicon glyphicon-leaf"></span> Report a bug</button>		
		</div>
	</footer>
	<!-- MODAL FOR BUG REPORT -->
	<div class="modal fade" id="bugreport" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Bug Report</h4>
				</div>
				<div class="modal-body text-center">
					<p><input class="form-control buggy-email" value="@if(Auth::check()){{Auth::user()->email}}@endif" type="text" placeholder="Your email address"></p>
					<p><textarea class="form-control buggy-message" rows="8" maxlength="" style="resize:none;" placeholder="ʕʘ‿ʘʔ What happened? Or you can also request a new feature here."></textarea></p>
					
					<input class="buggy-url" value="{{ URL::full() }}" type="hidden">
				</div>
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="post-buggy btn btn-small btn-success">Submit</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF MODAL FOR BUG REPORT -->
</body>

<!-- JS ESSENTIALS -->
<script src="/assets/plugins/jquery/jquery1.7.2.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/js/!ready.js"></script>

<!-- View-specific JS functions -->
@yield('custom-js')

<!-- Third party JS plugins -->
<script src="/assets/plugins/jsdiff-master/diff.js"></script>
<script src="/assets/plugins/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>

@if( Auth::check() )
<script type="text/javascript">
	
		var session_uid = {{ Auth::user()->user_id }};
		var session_email = "{{ Auth::user()->email }}";
	
</script>
@endif

<!-- GOOGLE ANALYTICS -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-43225311-1', 'williecheong.com');
	ga('send', 'pageview');
</script>
<!-- END OF GOOGLE ANALYTICS -->

</html>
