//INITIATING

//END INITIATION
	
	
//STATE FUNCTIONS
	$('.enable-editing').click(function(){
		if ( typeof session_uid !== 'undefined' ) {
			//Yes, user is logged in and OK to edit.
			$('.new-chap, .new-para, .edit-para').slideToggle('slow');
		} else {
			//No, user not logged in. send him to login screen
			window.location.href = '/user';
		}		
	});

	$('body').on('click', 'no-return', function(){
		return false;
	});
//END OF STATE FUNCTIONS
	
	
//MODAL SETTINGS
	$('.request-synopsis-modal').click(function(){
		$('#display-synopsis').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});
	});

	$('.new-chap-show').click(function(){
		var $this = $(this);
		
		$('.addnewchap-stor_id').val( $this.data('story') );
		$('.addnewchap-chap_ordering').val( $this.data('chapter-ordering') );
		
		$('#addnewchap').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});
	});
	
	$('.new-para-show').click(function(){
		var $this = $(this);
		
		$('.addnewpara-chap_id').val( $this.data('chapter') );
		$('.addnewpara-para_ordering').val( $this.data('para-ordering') );
		
		$('#addnewpara').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});
	});
	
	$('.edit-para-show').click(function(){
		var $this = $(this);
		
		$('.editpara-para_id').val( $this.data('paragraph') );	
		$('.editpara-old_content').val( $this.data('para-cont') );
		$('.editpara-cont_content').val( $this.data('para-cont').replace('&#34;', '"') );
		
		$('#editpara').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});
	});
//END OF MODAL SETTINGS
	
	
//STARTING A NEW CHAPTER
	$('.post-new-chap').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		
		//get the variables
		var content = $('.addnewchap-cont_content').val();
		var cont_desc = $('.addnewchap-cont_description').val();
		var stor_id = $('.addnewchap-stor_id').val();
		var chap_ordering = $('.addnewchap-chap_ordering').val();

		if ( $.trim(content) === '' ) {
			$('.addnewchap-cont_content').effect('shake','slow');
			$this.removeClass('disabled');
			return false;
		}

		if ( $.trim(cont_desc) === '' ) {
			$('.addnewchap-cont_description').effect('shake','slow');
			$this.removeClass('disabled');
			return false;
		}		

		var differences = JsDiff.diffWords('', content);
		
		$.ajax({
			url: '/api/contribute/chapter',
			type: 'POST',
			data: {	content : differences,
					cont_desc : cont_desc,
					stor_id : stor_id,
					chap_ordering : chap_ordering
				},
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					//display new chapter notice
					$('.new-chap-show[data-story="'+stor_id+'"][data-chapter-ordering="'+chap_ordering+'"]').closest('p.new-para').html('<div class="alert alert-success">You have contributed a chapter here. <a class="no-return" href="#">Edit it.</a></div>');
					
					//clear the values inside the modal
					$('.addnewchap-cont_content').val('');
					$('.addnewchap-cont_description').val('');
					$('.addnewchap-stor_id').val('');
					$('.addnewchap-chap_ordering').val('');
					$this.removeClass('disabled');
					
					//hide the modal
					$('#addnewchap').modal('hide');
					
				} else {
					console.log(response.status);
					alert('Failed to submit new chapter. Please try again.');
					$this.removeClass('disabled');
				
				}
				return false;
			}, 
			error: function(){
				alert('Error: Action could not be completed.');
				$this.removeClass('disabled');
			
			}, dataType: 'json'
		});
		
	});		
//END OF STARTING A NEW CHAPTER
	
	
//STARTING A NEW PARAGRAPH
	$('.post-new-para').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		
		//get the variables
		var content = $('.addnewpara-cont_content').val();
		var cont_desc = $('.addnewpara-cont_description').val();
		var chap_id = $('.addnewpara-chap_id').val();
		var para_ordering = $('.addnewpara-para_ordering').val();

		if ( $.trim(content) === '' ) {
			$('.addnewpara-cont_content').effect('shake','slow');
			$this.removeClass('disabled');
			return false;
		}

		if ( $.trim(cont_desc) === '' ) {
			$('.addnewpara-cont_description').effect('shake','slow');
			$this.removeClass('disabled');
			return false;
		}		

		var differences = JsDiff.diffWords('', content);
		
		$.ajax({
			url: '/api/contribute/paragraph',
			type: 'POST',
			data: {	content : differences,
					cont_desc : cont_desc,
					chap_id : chap_id,
					para_ordering : para_ordering
				},
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					//display new chapter notice
					$('.new-para-show[data-chapter="'+chap_id+'"][data-para-ordering="'+para_ordering+'"]').closest('p.new-para').html('<div class="alert alert-success">You have contributed a paragraph here. <a class="no-return" href="#">Edit it.</a></div>');
					
					//clear the values inside the modal
					$('.addnewpara-cont_content').val('');
					$('.addnewpara-cont_description').val('');
					$('.addnewpara-chap_id').val('');
					$('.addnewpara-para_ordering').val('');
					$this.removeClass('disabled');
					
					//hide the modal
					$('#addnewpara').modal('hide');
					
				} else {
					console.log(response.status);
					alert('Failed to submit new paragraph. Please try again.');
					$this.removeClass('disabled');
				
				}
				return false;
			}, 
			error: function(){
				alert('Error: Action could not be completed.');
				$this.removeClass('disabled');
			
			}, dataType: 'json'
		});
	});
//END OF STARTING A NEW PARAGRAPH
	
	
//EDITING AN EXISTING PARAGRAPH
	$('.post-edit-para').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		
		//get the variables
		var para_id = $('.editpara-para_id').val();
		var old_content = $('.editpara-old_content').val();
		var new_content = $('.editpara-cont_content').val();
		var cont_desc = $('.editpara-cont_description').val();
		
		if ( $.trim(cont_desc) === '' ) {
			$('.editpara-cont_description').effect('shake','slow');
			$this.removeClass('disabled');
			return false;
		}	

		var differences = JsDiff.diffWords(old_content, new_content);
		
		$.ajax({
			url: '/api/contribute/paragraph',
			type: 'PUT',
			data: {	para_id : para_id,
					content : differences,
					cont_desc : cont_desc
				},
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					//display edited paragraph notice
					$('.edit-para-show[data-paragraph='+para_id+']').html('');

					//Temporary false edit button because we're not ready to implement this yet.
					$('.edit-para-show[data-paragraph='+para_id+']').closest('p.existing-para').append('<a class="no-return" href="#"><small>Review your edits.</small></a>');
					
					//clear the values inside the modal
					$('.editpara-para_id').val('');
					$('.editpara-old_content').val('');
					$('.editpara-cont_content').val('');
					$('.editpara-cont_description').val('');
					$this.removeClass('disabled');
					
					//hide the modal
					$('#editpara').modal('hide');
					
				} else {
					console.log(response.status);
					alert('Failed to submit new paragraph. Please try again.');
					$this.removeClass('disabled');
				
				}
				return false;
			}, 
			error: function(){
				alert('Error: Action could not be completed.');
				$this.removeClass('disabled');
			
			}, dataType: 'json'
		});
		
	});
//END OF EDITING AN EXISTING PARAGRAPH	
