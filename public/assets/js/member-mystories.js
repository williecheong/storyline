//INITIATING

//END INITIATION
	
	
//STATE FUNCTIONS
	$('body').on('click','p.pending-head', function(){
		$('div.pending-body').toggle('slow');
	});

	$('body').on('click','p.merged-head', function(){
		$('div.merged-body').toggle('slow');
	});
	
	$('body').on('click','p.retired-head', function(){
		$('div.retired-body').toggle('slow');
	});

	$('body').on('click','button.toggle-ins', function(){
		$(this).closest('.accordion-body').find('ins').toggle('slow');
		return false;
	});
//END OF STATE FUNCTIONS
	
	
//MODAL SETTINGS
	$('.new-story-show').click(function(){
		$('#addnewstor').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});		
	});

	$('body').on('click','.edit-story-show',function(){
		$('input.edit-story-id').val( $(this).closest('.accordion-group').attr('id') );
		$('input.edit-story-title').val( $(this).closest('.accordion-group').find('span.story-title').html() );
		$('textarea.edit-story-synopsis').val( $(this).closest('.accordion-group').find('span.story-synopsis').html() );

		$('#editstory').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});		
	});
//END OF MODAL SETTINGS
	
//STARTING A NEW STORY
	$('.post-story').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		var title = $('input.new-story-title').val();
		var synopsis = $('textarea.new-story-synopsis').val();
		
		if ($.trim(title) === '') {
			$('input.new-story-title').effect('shake', 'slow');
			$this.removeClass('disabled');
			return false;
		}

		if ($.trim(synopsis) === '') {
			$('textarea.new-story-synopsis').effect('shake', 'slow');
			$this.removeClass('disabled');
			return false;
		}

		$.ajax({
			url: '/api/manage/story',
			type: 'POST',
			data: {	title : title,
					synopsis : synopsis
				},
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					var html = 
					'<div class="accordion-group" id="'+response.story.stor_id+'">'+
						'<div class="accordion-heading">'+
							'<a class="btn btn-default btn-xs pull-right" href="/read/'+response.story.stor_id+'"  title="READ" style="margin-left:3px;"><span class="glyphicon glyphicon-book" style="vertical-align:middle;"></span></a>' +
							'<a class="btn btn-default btn-xs pull-right" href="/moderate/'+response.story.stor_id+'"  title="CONTRIBUTIONS" style="margin-left:3px;"><span class="glyphicon glyphicon-edit" style="vertical-align:middle;"></span></a>' +
							'<a class="accordion-toggle" data-toggle="collapse" data-parent="#story-group" href="#collapse'+response.story.stor_id+'">'+
								'<span class="story-title">'+response.story.title+'</span>'+
							'</a>'+
						'</div>'+
						'<div id="collapse'+response.story.stor_id+'" class="accordion-body collapse">'+
							'<div class="accordion-inner">'+
								'<span class="story-synopsis">'+
									response.story.synopsis+
								'</span>'+
								'<button class="edit-story-show btn btn-xs btn-link">edit</button>'+
							'</div>'+
						'</div>'+
					'</div>';

					$('.no-stories').remove();
					$('.directing').append(html);
					
					//clear the values inside the modal
					$('input.new-story-title').val('');
					$('textarea.new-story-synopsis').val('');
					$this.removeClass('disabled');
					
					//hide the modal
					$('#addnewstor').modal('hide');
					
				} else {
					alert('Failed to create story. Please try again.');
					//re-enabled the posting button
					$this.removeClass('disabled');
				}
				return false;
			}, 
			error: function() {
				alert('Fail: API could not be reached.');
				$this.removeClass('disabled');
			}, dataType: 'json'
		});

	});
//END OF STARTING A NEW STORY.	


//STARTING EDITING A STORY
	$('.edit-story').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		var id = $('input.edit-story-id').val();
		var title = $('input.edit-story-title').val();
		var synopsis = $('textarea.edit-story-synopsis').val();
		
		if ($.trim(title) === '') {
			$('input.edit-story-title').effect('shake', 'slow');
			$this.removeClass('disabled');
			return false;
		}

		if ($.trim(synopsis) === '') {
			$('textarea.edit-story-synopsis').effect('shake', 'slow');
			$this.removeClass('disabled');
			return false;
		}

		$.ajax({
			url: '/api/manage/story',
			type: 'PUT',
			data: {	id : id,
					title : title,
					synopsis : synopsis
			},
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					//append the updated stuff
					$('.accordion-group[id='+id+']').find('span.story-title').html(title);
					$('.accordion-group[id='+id+']').find('span.story-synopsis').html(synopsis);

					$('#edit-story-modal').modal('hide');
					
					//clear the values inside the modal
					$('input.edit-story-id').val('');
					$('input.edit-story-title').val('');
					$('textarea.edit-story-synopsis').val('');

					$this.removeClass('disabled');
					
					//hide the modal
					$('#editstory').modal('hide');
					
				} else {
					alert('Failed to update story. Please try again.');
					//re-enabled the update button
					$this.removeClass('disabled');
				}
				return false;
			}, 
			error: function() {
				alert('Fail: API could not be reached.');
				$this.removeClass('disabled');
			}, dataType: 'json'
		});

	});
//END OF EDITING A STORY.	