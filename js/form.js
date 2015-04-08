var main = function() { 
	$('#work').click(function() {
			$('#salary').toggle();
		});
	
	$('#army').click(function() {
			$('#armyDays').toggle();
		});


};


$(document).ready(main);