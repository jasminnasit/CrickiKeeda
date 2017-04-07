$(document).ready(function(){
	$("span.errors").hide();
});

function verifyPls()
{
	var playersa=document.getElementsByClassName('playersa');
	var placnt=0;
	var playersb=document.getElementsByClassName('playersb');
	var plbcnt=0;
	for(var i=0;i<playersa.length;i++)
	{
		if (playersa[i].checked) {
			placnt++;
		}
	}
	if (placnt!==11) {
		$('html, body').animate({
			scrollTop: 0
		}, 1000);
		$("span.errorofpa").show(500);
		return false;
	}
	else
	{
		$("span.errorofpa").hide();
	}
	for(var i=0;i<playersb.length;i++)
	{
		if (playersb[i].checked) {
			plbcnt++;
		}
	}
	if (plbcnt!==11) {
		$('html, body').animate({
			scrollTop: $("#pl2tb").offset().top -50
		}, 1000);
		$("span.errorofpb").show(500);
		return false;
	}
	else
	{
		$("span.errorofpa").hide();
	}
}