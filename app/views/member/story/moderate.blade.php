@extends('template')

@section('pressed-manage')
	active
@stop

@section('content')
	<div class="story-title text-center">
		<h1>{{ $story['title'] }}</h1>
	</div>
	<div style="padding-bottom:10px">
		<p class="pending-head lead">Pending Contributions (<span class="pending-count">{{count($pending)}}</span>)</p>
		<div class="pending-body well well-small">
			
			@if( count($pending) == 0 )
				<span class="no-contributions">
					No pending contributions at the moment.<br>
					Share on your social networks and make this story grow!<br>
				</span>
				<div class="accordion" id="pending-group">
				</div>
			@else
				<div class="accordion" id="pending-group">
				@foreach( $pending AS $contribution )
					<div class="accordion-group" id="{{$contribution['cont_id']}}">
						<div class="accordion-heading">
							<div class="cont-action-buttons pull-right">
								<button class="btn btn-xs btn-success pull-right show-confirm-merge" data-cont_id="{{$contribution['cont_id']}}" style="margin-left:3px;">Merge</button>
								<button class="btn btn-xs btn-danger pull-right show-confirm-retire" data-cont_id="{{$contribution['cont_id']}}" style="margin-left:3px;">Retire</button>
							</div>
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#pending-group" href="#collapse{{ $contribution['cont_id'] }}">
								{{ $contribution['contype'] . ': ' . $contribution['description'] }} 
								<small><em>By {{ $contribution['author']['display'] }} (Submitted: {{ EasyText::makedate($contribution['updated_at']) }})</em></small>
							</a>
						</div>
						<div id="collapse{{ $contribution['cont_id'] }}" class="accordion-body collapse">
							<button class="toggle-ins btn btn-xs btn-default pull-right" style="margin-left:3px;">Toggle</button>
							<div class="accordion-inner">
								{{ $contribution['change_sample'] }}
							</div>
						</div>
					</div>
				@endforeach
				</div>
			@endif
		</div>
	</div>
	
	<div style="padding-bottom:10px">
		<p class="merged-head lead">Merged Contributions (<span class="merged-count">{{count($merged)}}</span>)</p>
		<div class="merged-body well well-small">
			@if( count($merged) == 0 )
				<span class="no-contributions">
					No merged contributions at the moment.<br>
					Share on your social networks and make this story grow!<br>
				</span>
				<div class="accordion" id="merged-group">
				</div>
			@else
				<div class="accordion" id="merged-group">
				@foreach( $merged AS $contribution )
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#merged-group" href="#collapse{{ $contribution['cont_id'] }}">
								{{ $contribution['contype'] . ': ' . $contribution['description'] }} 
								<small><em>By {{ $contribution['author']['display'] }} (Merged: {{ EasyText::makedate($contribution['updated_at']) }})</em></small>
							</a>
						</div>
						<div id="collapse{{ $contribution['cont_id'] }}" class="accordion-body collapse">
							<button class="toggle-ins btn btn-xs btn-default pull-right" style="margin-left:3px;">Toggle</button>
							<div class="accordion-inner">
								{{ $contribution['snapshot'] }}
							</div>
						</div>
					</div>
				@endforeach
				</div>
			@endif
		</div>
	</div>
	
	<div style="padding-bottom:10px">
		<p class="retired-head lead">Retired Contributions (<span class="retired-count">{{count($retired)}}</span>)</p>
		<div class="retired-body well well-small">
			@if( count($retired) == 0 )
				<span class="no-contributions">
					No retired contributions at the moment.<br>
					Share on your social networks and make this story grow!<br>
				</span>
				<div class="accordion" id="retired-group">
				</div>
			@else
				<div class="accordion" id="retired-group">
				@foreach( $retired AS $contribution )
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#retired-group" href="#collapse{{ $contribution['cont_id'] }}">
								{{ $contribution['contype'] . ': ' . $contribution['description'] }} 
								<small><em>By {{ $contribution['author']['display'] }} (Retired: {{ EasyText::makedate($contribution['updated_at']) }})</em></small>
							</a>
						</div>
						<div id="collapse{{ $contribution['cont_id'] }}" class="accordion-body collapse">
							<button class="toggle-ins btn btn-xs btn-default pull-right" style="margin-left:3px;">Toggle</button>
							<div class="accordion-inner">
								{{ $contribution['snapshot'] }}
							</div>
						</div>
					</div>
				@endforeach
				</div>
			@endif
		</div>
	</div>
	
	<!-- Modal for CONFIRMING MERGE -->
	<div id="confirm-merge" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
					<h4 id="myModalLabel">Merge confirmation</h4>
				</div>
				
				<div class="modal-body">
					Merge actions cannot be reversed. <br>
					Are you sure you want to continue?
				</div>
				
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="execute-merge btn btn-success" data-cont_id="">Merge</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END MODAL for CONFIRMING MERGE -->

	<!-- Modal for CONFIRMING RETIRE -->
	<div id="confirm-retire" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
					<h4 id="myModalLabel">Retire confirmation</h4>
				</div>
				
				<div class="modal-body">
					Retire actions cannot be reversed. <br>
					Are you sure you want to continue?
				</div>
				
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="execute-retire btn btn-danger" data-cont_id="">Retire</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END MODAL for CONFIRMING RETIRE -->
@stop

@section('custom-js')
	<script src="/assets/js/moderate-single.js"></script>
@stop