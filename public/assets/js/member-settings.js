

//STATE FUNCTIONS
$('button.request-change-password').click(function(){
	$('div.change-password').slideToggle('slow');
});
//END OF STATE FUNCTIONS


//Password change on submit
	$('button.member-settings').click(function(){
		var password = $('input.password').val();
		var c_password = $('input.confirm_password').val();

		$.ajax({
			url: '/api/user/settings',
			type: 'PUT',
			data: {	password : password,
					c_password : c_password
			},
			success: function(response) {

				if( response.status === 'success' ){

				$('div.settings').html("Your Password Has Been Changed");
					
				} else {
				$('div.settings').html("<span class='glyphicon glyphicon-exclamation-sign'></span> "+response.fail_1+"<br /><span class='glyphicon glyphicon-exclamation-sign'></span> "+response.fail_2);
				}
				return false;
			}, 
			error: function() {
				alert('Failed to change your password');
			}, dataType: 'json'
		});	
	});
//END OF password change on submit
