$(document).ready(function() {
	
	/*** form validations ***/
	$('form[name="login"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: true});
	$('form[name="signup"]').validationEngine('attach', {promptPosition : "bottomLeft", scroll: true});
	
});
