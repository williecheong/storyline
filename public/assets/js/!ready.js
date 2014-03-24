$(document).ready(function() {
	//INITIATING
	//END INITIATION
	
	
	//STATE FUNCTIONS
	//END OF STATE FUNCTIONS
	
	
	//MODAL SETTINGS
	$('.show-buggy').click(function(){
		$('#bugreport').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});		
	});
	//END OF MODAL SETTINGS
	

	//SUBMITTING A BUGGY
	$('.post-buggy').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		var email = $('input.buggy-email').val();
		var message = $('textarea.buggy-message').val();
		var url = $('input.buggy-url').val();
		
		if ($.trim(message) === '') {
			$('textarea.buggy-message').effect('shake', 'slow');
			$this.removeClass('disabled');
			return false;
		}

		$.ajax({
			url: '/api/feedback',
			type: 'POST',
			data: {	email : email,
					message : message,
					url : url
				},
			success: function(response) {
				if( response.status === 'success' ){
					//disable the report bug button on this page.
					$('button.show-buggy').addClass('disabled').html('Bug reported ٩(●̮̃•)۶');

					//clear the values inside the modal
					$('input.buggy-email').val('');
					$('textarea.buggy-message').val('');
					$('input.buggy-url').val('');
					$this.removeClass('disabled');
					
					//hide the modal
					$('#bugreport').modal('hide');

				} else {
					alert('Failed to submit bug report. Please try again.');
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
	//END OF SUBMITTING A BUGGY


});