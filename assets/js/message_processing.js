(function($){
	// Parse the URL parameter
	function getParameterByName(name, url) {
	    if (!url) {
	    	url = location.href.split("?msg=").slice(-1)[0];
	    }

	    return url;

	}
	// Give the parameter a variable name
	var dynamicContent = getParameterByName('msg');

	 $(document).ready(function() {

		// Contacto: newsletter Processing
		if (dynamicContent == 'error') {
			$('#error').show();
		}
		else if (dynamicContent == 'confirmation_sent') {
			$('#confirmation_sent').show();
		}
		else if (dynamicContent == 'subscribed') {
			$('#subscribed').show();
		}
		// Check if the URL parmeter is empty or not defined, display default content
		else {
			$('#default-content').show();
		}
	});
})(jQuery);
