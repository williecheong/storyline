@extends('template')

@section('pressed-manage')
	active
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php /*<button class="btn-mini pull-right"><i class="icon-search"></i> More stories</button> */ ?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<span class="lead">Following</span>
					</div>
					Coming soon
				</div>
			</div>
		</div>
	</div>
	
	<div style="padding-bottom:10px">
		<div class="row">
			<div class="col-lg-12">
				<button class="new-story-show btn btn-default btn-xs pull-right">
					<span class="glyphicon glyphicon-file"></span>
					Create new
				</button>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<span class="lead">Directing</span>
					</div>
					<ul class="list-group">
						@if( count($stories) == 0 )
							<li class="list-group-item no-stories">
								No stories for you to direct yet.<br>
								Would you like to create a new one?<br>
								Or you could also adopt an orphaned story.
							</li>
							<div class="directing accordion" id="story-group"></div>
						@else
							<div class="directing accordion" id="story-group">
							@foreach( $stories AS $story )
								<div class="accordion-group" id="{{ $story->stor_id }}">	
									<div class="accordion-heading">
										<a class="btn btn-default btn-xs pull-right" href="/read/{{ $story->stor_id }}"  title="READ" style="margin-left:3px;"><span class="glyphicon glyphicon-book" style="vertical-align:middle;"></span></a>
										<a class="btn btn-default btn-xs pull-right" href="/moderate/{{ $story->stor_id }}"  title="CONTRIBUTIONS" style="margin-left:3px;"><span class="glyphicon glyphicon-edit" style="vertical-align:middle;"></span></a>
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#story-group" href="#collapse{{ $story->stor_id }}">
											<span class="story-title">{{ $story->title }}</span>
										</a>
									</div>
									
									<div class="accordion-body collapse" id="collapse{{ $story->stor_id }}">
										<div class="accordion-inner">
											<span class="story-synopsis">{{ $story->synopsis }}</span> 
											<button class="edit-story-show btn btn-xs btn-link">edit</button>
										</div>
									</div>
								</div>

							@endforeach
							</div>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<span class="lead">My Contributions</span>
				</div>
				<p class="pending-head">Pending ({{ count($pending) }})</p>
				<div class="pending-body accordion" id="pending-group" style="display:none;">
					@foreach( $pending AS $pcont )
						<div class="accordion-group" id="{{ $pcont['cont_id'] }}">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#pending-group" href="#collapse{{ $pcont['cont_id'] }}">
									{{ $pcont['story']['title'] }}: {{ $pcont['description'] }} 
									<small><em>Submitted: {{ EasyText::makedate($pcont['updated_at']) }}</em></small>
								</a>
							</div>
							
							<div class="accordion-body collapse" id="collapse{{ $pcont['cont_id'] }}">
								<button class="toggle-ins btn btn-xs btn-default pull-right" style="margin-left:3px;">Toggle</button>
								<div class="accordion-inner">
									{{ $pcont['change_sample'] }}
								</div>
							</div>	
						</div>
					@endforeach
				</div>
				<p class="merged-head">Merged ({{ count($merged) }})</p>
				<div class="merged-body accordion" id="merged-group" style="display:none;">
					@foreach( $merged AS $mcont )
						<div class="accordion-group" id="{{ $mcont['cont_id'] }}">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#merged-group" href="#collapse{{ $mcont['cont_id'] }}">
									{{ $mcont['story']['title'] }}: {{ $mcont['description'] }} 
									<small><em>Merged: {{ EasyText::makedate($mcont['updated_at']) }}</em></small>
								</a>
							</div>
							
							<div class="accordion-body collapse" id="collapse{{ $mcont['cont_id'] }}">
								<button class="toggle-ins btn btn-xs btn-default pull-right" style="margin-left:3px;">Toggle</button>
								<div class="accordion-inner">
									{{ $mcont['snapshot'] }}
								</div>
							</div>	
						</div>
					@endforeach
				</div>
				<p class="retired-head">Retired ({{ count($retired) }})</p>
				<div class="retired-body accordion" id="retired-group" style="display:none;">
					@foreach( $retired AS $rcont )
						<div class="accordion-group" id="{{ $rcont['cont_id'] }}">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#retired-group" href="#collapse{{ $rcont['cont_id'] }}">
									{{ $rcont['story']['title'] }}: {{ $rcont['description'] }} 
									<small><em>Retired: {{ EasyText::makedate($rcont['updated_at']) }}</em></small>
								</a>
							</div>
							
							<div class="accordion-body collapse" id="collapse{{ $rcont['cont_id'] }}">
								<button class="toggle-ins btn btn-xs btn-default pull-right" style="margin-left:3px;">Toggle</button>
								<div class="accordion-inner">
									{{ $rcont['snapshot'] }}
								</div>
							</div>	
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	
	
	
	<!-- Modal for creating new story -->
	<div id="addnewstor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Story</h4>
				</div>		
				
				<div class="modal-body text-center">
					<p><input class="form-control new-story-title" maxlength="100" type="text" placeholder="Story title"></p>
					<p><textarea class="form-control new-story-synopsis" rows="15" style="resize:none;" placeholder="Synopsis - Write a small paragraph describing this story. Captivate your audience; attract more contributors."></textarea></p>
				</div>
				
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="post-story btn btn-small btn-success">Begin</button>
				</div>

			</div>
		</div>
	</div>
	<!-- END MODAL for creating new story -->

	<!-- Modal for editing a story -->
	<div id="editstory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Story</h4>
				</div>		
				
				<div class="modal-body text-center">
					<p><input class="form-control edit-story-title" maxlength="100" type="text" placeholder="Story title"></p>
					<p><textarea class="form-control edit-story-synopsis" rows="15" style="resize:none;" placeholder="Synopsis - Write a small paragraph describing this story. Captivate your audience; attract more contributors."></textarea></p>
					<input class="edit-story-id" type="hidden">
				</div>
				
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="edit-story btn btn-small btn-success">Edit</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END MODAL for editing synopsis -->
@stop



@section('custom-js')
	<script src="/assets/js/member-mystories.js"></script>
@stop