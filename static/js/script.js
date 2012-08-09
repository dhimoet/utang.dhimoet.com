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
				url: "/ajax/sendReport/",
				type: "POST",
				async: false,
				data: {title : title, description : description},
				success: function(data) {
					if(data == "success") {
						alert('The report has been filed.');
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
	
	
});
