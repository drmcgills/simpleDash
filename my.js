$(document).ready(function() {
	$('input').click(function() {
		$.Storage.set("titletext", $(this).val());
		$(this).val("");
	});
});