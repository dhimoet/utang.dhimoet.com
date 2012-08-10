$(document).delegate("", "pageinit", function() {
	
	/*** form validations ***/
	$('form[name="login"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
	$('form[name="signup"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
	$('form[name="add_transaction"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
	$('form[name="add_friend"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
	$('form[name="change_password"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
	$('form[name="report_tool"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
	
	/*** send email ***/
	$('form[name="report_tool"]').submit(function() {
		if($('form[name="report_tool"]').validationEngine('validate')) {
			var title = $('#title').val();
			var description = $('#description').val();
			$.ajax({
				url: "/ajax/send_report/",
				type: "POST",
				async: false,
				data: {title : title, description : description},
				success: function(data) {
					if(data == "success") {
						alert('The report has been submitted.');
						return true;
					}
					else {
						alert('Error: Please try again.');
						return false;
					}
				},
				error: function() {
					alert('Error: Please try again.');
					return false;
				}
			});
		}
	});
	
	/*** search for user names ***/
	$('#name').focus(function() {
		$('#name').ajaxStop().keyup(function() {
			if($('#name').val().length > 2) {
				var key = $('#name').val();
				// open database and search
				$.ajax({
					url: "/ajax/get_users/",
					type: "POST",
					data: {key : key},
					beforeSend: function() {
						$('#user_list').empty();
					},
					success: function(data) {
						get_user_list(data);
					}
				});
			}
		});
	});
});
