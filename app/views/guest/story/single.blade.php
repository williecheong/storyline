@extends('template')

@section('pressed-stories')
	active
@stop

@section('content')
	<?php
		$chapter_num = 1; 
		$prev_chap_ordering = 0;
		$new_chap_ordering = 0;
		
		//Must be reset at every chapter
		$prev_para_ordering = 0;
		$new_para_ordering = 0;
	?>
	
	<!-- Big story title on top of page -->
	<div class="row" style="margin-bottom:10px;">
		<div class="col-lg-offset-1"></div>
		<div class="story-title text-center col-lg-10 col-lg-offset-1">
			<h1><span class="request-synopsis-modal">{{ $story['title'] }}</span></h1>
		</div>
		<div class="col-lg-1 text-center">
			<button class="btn enable-editing">Edit</button>
		</div>
	</div>
	@foreach($chapters as $chapter)
		<?php $prev_para_ordering = 0; ?>
		
		{{-- START of option to add an in between chapter --}}
		<div class="new-chap chapter-content well">
			<p class="new-para">
				<?php $new_chap_ordering = ($prev_chap_ordering + $chapter['ordering']) / 2 ; ?>
				<a class="new-chap-show" data-author="{{$user_id}}" data-story="{{$story['stor_id']}}" data-chapter-ordering="{{$new_chap_ordering}}">
					<em><small>Psst, come add a new chapter here.</small></em>
				</a>
			</p>
		</div>
		{{-- END of option to add an in between chapter --}}
		
		<div class="chapter-content well"> 
			<p class="lead">
				Chapter {{ $chapter_num }} 
				@if( !empty($chapter['title']) )<small>{{$chapter['title']}}</small>@endif
			</p>
			
			{{-- START of paragraphing for THIS chapter --}}
			@foreach($chapter['paragraphs'] as $paragraph)
				{{-- Option to add new paragraph before the new one --}}
				<p class="new-para">
					<?php $new_para_ordering = ($prev_para_ordering + $paragraph['ordering']) / 2; ?>
					<a class="new-para-show" data-author="{{$user_id}}" data-chapter="{{$chapter['chap_id']}}" data-para-ordering="{{ $new_para_ordering }}">
						<em><small>Add a new paragraph here.</small></em>
					</a>
				</p>
				{{-- Displays the next-in-line and edit paragraph option --}}
				<p class="existing-para">
					{{ EasyParagraph::htmlreadify( EasyParagraph::untrack( $paragraph['content'] ) ) }} 
					<a class="edit-para-show edit-para" data-author="'.$user_id.'" data-paragraph="{{$paragraph['para_id']}}" data-para-cont="{{EasyText::esc_doublequote(EasyParagraph::textreadify(EasyParagraph::untrack( $paragraph['content'])))}}"><small>edit</small></a>
				</p>
				<?php $prev_para_ordering = $paragraph['ordering']; ?>
			@endforeach
			{{-- END of paragraphing for THIS chapter --}}
			
			{{-- START of option to add new paragraph at the END OF CHAPTER. --}}
			<p class="new-para">
				<?php $new_para_ordering = $prev_para_ordering + 10000; ?>
				<a class="new-para-show" data-author="{{$user_id}}" data-chapter="{{$chapter['chap_id']}}" data-para-ordering="{{ $new_para_ordering }}">
					<em><small>Add a new paragraph here.</small></em>
				</a>
			</p>
			{{-- END of option to add new paragraph at the END OF CHAPTER. --}}
			
		</div>
		<?php $prev_chap_ordering = $chapter['ordering']; $chapter_num++; ?>
	
	@endforeach	
	
	{{-- START of option to add new chapter at END OF STORY --}}	
	<div class="new-chap chapter-content well">
		<p class="lead">Chapter {{ $chapter_num }}</p>
		<p class="new-para">
			<?php $new_chap_ordering = $prev_chap_ordering + 10000; ?>
			<a class="new-chap-show" data-author="{{$user_id}}" data-story="{{$story['stor_id']}}" data-chapter-ordering="{{$new_chap_ordering}}">
				<em><small>Psst, come add a new chapter here.</small></em>
			</a>
		</p>
	</div>
	{{-- END OF option to add new chapter at END OF STORY --}}

	
	{{-- That's all for the main view.      --}}
	

	<!-- MODAL FOR DISPLAYING SYNOPSIS -->
	<div class="modal fade" id="display-synopsis" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">{{ $story['title'] }}</h4>
				</div>
				<div class="modal-body">			
					<p>{{ $story['synopsis'] }}</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF MODAL FOR DISPLAYING SYNOPSIS -->

	{{-- Defining content for 3 modals now  --}}
	{{-- #addnewchap #addnewpara #editpara  --}}
	<!-- MODAL FOR ADDING NEW CHAPTERS  -->
	<div class="modal fade" id="addnewchap" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Contribute - New chapter</h4>
				</div>
				<div class="modal-body text-center">			
					<p><textarea class="form-control addnewchap-cont_content" rows="14" style="resize:none;" placeholder="Your new chapter for this story; write away..."></textarea></p>
					<p><textarea class="form-control addnewchap-cont_description" rows="3" maxlength="" style="resize:none;" placeholder="Briefly describe this contribution. This will only serve as a summary to help directors moderate."></textarea></p>
					
					<input class="addnewchap-stor_id" value="" type="hidden">
					<input class="addnewchap-chap_ordering" value="" type="hidden">
				</div>
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="post-new-chap btn btn-small btn-success">Submit</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF MODAL FOR ADDING NEW CHAPTERS  -->

	<!-- MODAL FOR ADDING NEW PARAGRAPHS -->
	<div class="modal fade" id="addnewpara" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Contribute - New paragraph</h4>
				</div>
				<div class="modal-body text-center">
					<p><textarea class="form-control addnewpara-cont_content" rows="14" style="resize:none;" placeholder="Your new paragraph for this story chapter; write away..."></textarea></p>
					<p><textarea class="form-control addnewpara-cont_description" rows="3" maxlength="" style="resize:none;" placeholder="Briefly describe this contribution. This will only serve as a summary to help directors moderate."></textarea></p>
					
					<input class="addnewpara-chap_id" value="" type="hidden">
					<input class="addnewpara-para_ordering" value="" type="hidden">
				</div>
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="post-new-para btn btn-small btn-success">Submit</button>
				</div>
			</div>
		</div>	
	</div>
	<!-- END OF MODAL FOR ADDING NEW PARAGRAPHS -->
	
	<!-- MODAL FOR EDITING EXISTING PARAGRAPHS  -->
	<div class="modal fade" id="editpara" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Contribute - Edit paragraph</h4>
				</div>
				<div class="modal-body text-center">
					<p><textarea class="form-control editpara-cont_content" rows="14" style="resize:none;" placeholder="Make your edits to this paragraph here."></textarea></p>
					<p><textarea class="form-control editpara-cont_description" rows="3" maxlength="" style="resize:none;" placeholder="Briefly describe this contribution. This will only serve as a summary to help directors moderate."></textarea></p>
					
					<input class="editpara-old_content" value="" type="hidden">
					<input class="editpara-para_id" value="" type="hidden">
				</div>
				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="post-edit-para btn btn-small btn-success">Submit</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF MODAL FOR EDITING EXISTING PARAGRAPHS  -->	
@stop

@section('custom-js')
	<script src="/assets/js/read-single.js"></script>
@stop