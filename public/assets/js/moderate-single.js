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
	$('.show-confirm-merge').click(function(){
		$('button.execute-merge').attr('data-cont_id', $(this).data('cont_id') );
		$('#confirm-merge').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});
	});

	$('.show-confirm-retire').click(function(){
		$('button.execute-retire').attr('data-cont_id', $(this).data('cont_id') );
		$('#confirm-retire').modal({
			backdrop : true,
			keyboard : true,
			show	 : true
		});
	});
//END OF MODAL SETTINGS
	

//MERGING A CONTRIBUTION
	$('.execute-merge').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		
		//get the variables
		var cont_id = $this.data('cont_id');

		$.ajax({
			url: '/api/moderate/merge',
			type: 'POST',
			data: {	cont_id : cont_id },
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					//copy then remove this from pending
					$('.accordion-group[id="'+cont_id+'"]').find('.cont-action-buttons').hide();
					var cont_display = $('.accordion-group[id="'+cont_id+'"]').html();
					$('.accordion-group[id="'+cont_id+'"]').hide('slow');
					
					//send this to merged section.
					$('#merged-group').prepend('<div class="accordion-group">'+cont_display+'</div>');
					//delete any no contribution text inside here
					$('.merged-body span.no-contributions').remove();
					
					//update counters
					$('span.pending-count').html( parseInt($('span.pending-count').html()) - 1 );
					$('span.merged-count').html( parseInt($('span.merged-count').html()) + 1 );
					
					$this.attr('data-cont_id', '');
					$this.removeClass('disabled');

					//hide the modal
					$('#confirm-merge').modal('hide');
					
					setTimeout(
						'location.reload(true);', 300
					);

				} else {
					alert('Failed to merge this contribution. Please try again.');
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
//END OF MERGING A CONTRIBUTION
	

//RETIRING A CONTRIBUTION
	$('.execute-retire').click(function(){
		var $this = $(this);
		$this.addClass('disabled');
		
		//get the variables
		var cont_id = $this.data('cont_id');

		$.ajax({
			url: '/api/moderate/retire',
			type: 'POST',
			data: {	cont_id : cont_id },
			success: function(response) {
				if( response.status === 'noSession' ){
					window.location.href = '/user';
				} else if( response.status === 'success' ){
					//copy then remove this from pending
					$('.accordion-group[id="'+cont_id+'"]').find('.cont-action-buttons').hide();
					var cont_display = $('.accordion-group[id="'+cont_id+'"]').html();
					$('.accordion-group[id="'+cont_id+'"]').hide('slow');
					
					//send this to retired section.
					$('#retired-group').prepend('<div class="accordion-group">'+cont_display+'</div>');
					//delete any no contribution text inside here
					$('.retired-body span.no-contributions').remove();
					
					//update counters
					$('span.pending-count').html( parseInt($('span.pending-count').html()) - 1 );
					$('span.retired-count').html( parseInt($('span.retired-count').html()) + 1 );
					
					$this.attr('data-cont_id', '');
					$this.removeClass('disabled');

					//hide the modal
					$('#confirm-retire').modal('hide');

					setTimeout(
						'location.reload(true);', 300
					);
					
				} else {
					alert('Failed to retire this contribution. Please try again.');
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
//END OF RETIRING A CONTRIBUTION	
