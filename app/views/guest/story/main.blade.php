@extends('template')

@section('pressed-stories')
	active
@stop

@section('content')
	<div style="padding-bottom:10px">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<span class="lead">Top Stories</span>
					</div>
					<ul class="list-group">
						<div class="top-stories accordion" id="story-group">
						@foreach( $stories AS $story )
							<div class="accordion-group" id="{{ $story['stor_id'] }}">	
								<div class="accordion-heading">
									<a class="btn btn-default btn-xs pull-right" href="/read/{{ $story['stor_id'] }}"  title="READ" style="margin-left:3px;"><span class="glyphicon glyphicon-book" style="vertical-align:middle;"></span></a>
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#story-group" href="#collapse{{ $story['stor_id'] }}">
										<span class="story-title">{{ $story['title'] }}</span>
									</a>
								</div>
								
								<div class="accordion-body collapse" id="collapse{{ $story['stor_id'] }}">
									<div class="accordion-inner">
										<span class="story-synopsis">{{ $story['synopsis'] }}</span> 
									</div>
								</div>
							</div>
						@endforeach
						</div>
						
					</ul>
				</div>
			</div>
		</div>
	</div>
@stop