$(document).ready(function(){
	$("span.errors").hide();
	$("span.errorst").hide();
	$("span.errorstc").hide();
	var teamap='Team1';
	var teambp='Team12';
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