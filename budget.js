
var datePicker = document.getElementById("datePicker");

function setDate(){
	const element = document.getElementById('datePicker');
	element.valueAsNumber = Date.now()-(new Date()).getTimezoneOffset()*60000;
}

