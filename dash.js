$(document).ready(function() {
	var prevText
	$('div.postheader > input').focus(function() {
		prevText = $(this).val();
		$(this).val('');
	});
	$('div.postheader > input').blur(function() {
		if($(this).val() == '')
		{
			$(this).val(prevText);
		}
	});
});