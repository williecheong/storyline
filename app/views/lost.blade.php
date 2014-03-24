@extends('template')

@section('content')
	<p class="lead">ERROR: 404</p>
	<p>We couldn't find the page you were looking for.<br>
	Are you sure that the following is a valid extension?</p>
	{{ URL::full() }} 
@stop