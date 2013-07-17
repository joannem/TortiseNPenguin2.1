/* Javascript functions to create dynamic forms*/

//For income

function firstCheck_In() {
	//console.log("in firstCheck_In()");
	if(document.getElementById("monthly").checked) {
		//To: options
		//document.getElementById("endDay").disabled = true; #endDay would be disabled regardless
		document.getElementById("endMonth").disabled = false;
		document.getElementById("endYear").disabled = false;
	} else {
		//radio options
		document.getElementById("endDate_S").disabled = true;
		document.getElementById("endDate_US").disabled = true;
		//To: options
		document.getElementById("endDay").disabled = true;
		document.getElementById("endMonth").disabled = true;
		document.getElementById("endYear").disabled = true;
	}
}
function SetSelect_In(status) {
	//document.getElementById("endDay").disabled = status;
	document.getElementById("endMonth").disabled = status;
	document.getElementById("endYear").disabled = status;
}

function CheckedSetSelect_In(option) {
	//console.log("in CheckedSetSelect_addIn()");
	console.log(option);
	if (document.getElementById("monthly").checked) {
		document.getElementById("endDay").options[option].selected = true;
		document.getElementById("startDay").disabled = true;
		//radio options
		document.getElementById("endDate_S").disabled = false;
		document.getElementById("endDate_US").disabled = false;
		//To: options
		//document.getElementById("endDay").disabled = true; #endDay would be disabled regardless
		document.getElementById("endMonth").disabled = false;
		document.getElementById("endYear").disabled = false;
	}
	else {
		document.getElementById("startDay").disabled = false;
		//radio options
		document.getElementById("endDate_S").disabled = true;
		document.getElementById("endDate_US").disabled = true;
		//To: options
		document.getElementById("endDay").disabled = true;
		document.getElementById("endMonth").disabled = true;
		document.getElementById("endYear").disabled = true;
	}
}

//For budget

function SetSelect_Bud(status) {
	document.getElementById("startMonth").disabled = status;
	document.getElementById("startYear").disabled = status;
	document.getElementById("endMonth").disabled = status;
	document.getElementById("endYear").disabled = status;
}

function firstCheck_Bud() {
	console.log("in firstCheck_Bud()");
	if(document.getElementById("choosePeriod").checked) {
		document.getElementById("startMonth").disabled = false;
		document.getElementById("startYear").disabled = false;
		document.getElementById("endMonth").disabled = false;
		document.getElementById("endYear").disabled = false;
	} else {
		document.getElementById("startMonth").disabled = true;
		document.getElementById("startYear").disabled = true;
		document.getElementById("endMonth").disabled = true;
		document.getElementById("endYear").disabled = true;
	}
}