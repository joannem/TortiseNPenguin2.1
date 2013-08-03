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
		//radio options
		document.getElementById("endDate_S").disabled = false;
		document.getElementById("endDate_US").disabled = false;
		//To: options
		//document.getElementById("endDay").disabled = true; #endDay would be disabled regardless
		document.getElementById("endMonth").disabled = false;
		document.getElementById("endYear").disabled = false;
	}
	else {
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

//For editing categories

function edit(cat){
	//console.log("in hideEdit");
	editBtnId = "edit_" + cat;
	textId = "cat_" + cat;
	document.getElementById(textId).disabled = false;
	document.getElementById(editBtnId).disabled = true;
	document.getElementById("save").disabled = false;

}

//For registration

function checkReg(){
	if(checkFilled()) {
		alert("Please make sure all fields are filled up.");	
	}
	else if(matchPass()) {
		alert("1st and 2nd passwords are unidentical.")
	}
	else {
		document.getElementById("submitButton").setAttribute('type', 'submit');	
	}

}

// returns false if all information are filled and true otherwise
function checkFilled() {
	if(document.getElementById("username").value == null || document.getElementById("password1") == null || document.getElementById("password2") == null || document.getElementById("emailAddress") == null || document.getElementById("firstName") == null || document.getElementById("lastName") == null || !(checkGender())) {
		console.log("username: " + document.getElementById("username").value + "\n");
		console.log("password1: " + document.getElementById("password1").value + "\n");
		console.log("password2: " + document.getElementById("password2").value + "\n");
		console.log("emailAddress: " + document.getElementById("emailAddress").value + "\n");
		console.log("firstName: " + document.getElementById("firstName").value + "\n");
		console.log("lastName: " + document.getElementById("lastName").value + "\n");
		return true;
	} else {
		return false;
	}
		
}
// returns true if gender is checked
function checkGender() {
	if(document.getElementById("genderMale").checked || document.getElementById("genderFemale").checked)
		return true;
	else
		return false;
}
// returns true if 1st and 2nd passwords are unidentical
function matchPass() {
	if(document.getElementById("password1").value != document.getElementById("password2").value)
		return true;
	else
		return false;
}