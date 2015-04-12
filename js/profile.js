var main = function() { 
	$('.moreButtonDiv').click(function() {
			//$(this).parents('div').find('.bottom').toggle();
			$(this).next().toggle();
		});
};


$(document).ready(main);