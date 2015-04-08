var main = function() { 
	$('#work').click(function() {
			$('#salary').toggle();
		});
	
	$('#army').click(function() {
			$('#armyDays').toggle();
		});
	
	$('#addCheckListButton').click(function() {
		$('#checklist').append( "<li>the checkList: <textarea form'myprofile' name=\"checklist\"> </textarea ><br></li>" );
		});
	$('#removeCheckListButton').click(function() {
		$('#checklist').children("li").last().remove();
		});
	


//.css( "color", "red" );
// $( "div.checklist" ).click(function() {
//   var htmlString = $( this ).html();
//   $( this ).text( htmlString );


};


$(document).ready(main);