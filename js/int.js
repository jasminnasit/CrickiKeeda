$(document).ready(function(){
	$("span.errors").hide();
	var teamap=$("#teama").val();
	var teambp=$("#teamb").val();
	$("#teama").change(function(){
		if ($("#teama").val()==$("#teamb").val()) {
			$("span.errors").show(500);
			$("#teama").val(teamap);
		}
		else
		{
			teamap=$("#teama").val();
			$("span.errors").hide(500);
			$("#teamai").val($("#teama").val());
			$("#teamac").html($("#teama").val());
		}
	});

	$("#teamb").change(function(){
		if ($("#teama").val()==$("#teamb").val()) {
			$("span.errors").show(500);
			$("#teamb").val(teambp);
		}
		else
		{
			teambp=$("#teamb").val();
			$("span.errors").hide(500);
			$("#teambi").val($("#teamb").val());
			$("#teambc").html($("#teamb").val());
		}
	});

});

function checkTeams(){
	if ($("#teama").val()==$("#teamb").val()) {
		$("span.errors").show(500);
		return false;
	}
	else{
		return true;
	}
}