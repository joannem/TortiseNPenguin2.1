<?php

require_once("common.inc.php");

if(isset($_POST["action"]) and $_POST["action"] == "register") {
	processForm();
} else {
	displayForm(array(), array(), new Member(array()));
}

function displayForm($errorMessages, $missingFields, $member) {
	displayLogHeader("Registration"); ?>

	<h3>Thank you for registering with us.</h3>
	<?php 
	if($errorMessages) {
		foreach ($errorMessages as $errorMessage) {
			echo $errorMessage;
		}
	} 	?>	
			
	<p>To register, please fill in your details below and click Send Details.</p>
	<p>Please fill up all fields.</p>

	<form class="form-horizontal" action="registration.php" method="post">
		<div style="width: 50em;">
			<input type="hidden" name="action" value="register" />

			<div class="control-group">
				<label class="control-label<?php validateField("username", $missingFields)?>" for="username" >Choose a username :</label>
				<div class="controls">
					<input type="text" name="username" id="username" value="<?php echo $member->getValueEncoded("username")?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label<?php if ($missingFields) echo ' error'?>" for="password1">Choose a password :</label>
				<div class="controls">
					<input type="password" name="password1" id="password1" value="" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label<?php if ($missingFields) echo ' error'?>" for="password2">Retype password :</label>
				<div class="controls">
					<input type="password" name="password2" id="password2" value="" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label<?php validateField("emailAddress", $missingFields)?>" for="emailAddress">Email address :</label>
				<div class="controls">
					<input type="text" name="emailAddress" id="emailAddress" value="<?php echo $member->getValueEncoded("emailAddress")?>" />
				</div>
			</div>

			<!--Start of Name & Gender-->
			<div class="control-group">
				<label class="control-label<?php validateField("firstName", $missingFields)?>" for="firstName">First name :</label>
				<div class="controls">
					<input type="text" name="firstName" id="firstName" value="<?php echo $member->getValueEncoded("firstName")?>" />

				</div>
			</div>
			<div class="contorl-group">
				<label class="control-label<?php validateField("lastName", $missingFields)?>" for="lastName">Last name :</label>
				<div class="controls">
					<input type="text" name="lastName" id="lastName" value="<?php echo $member->getValueEncoded("lastName")?>" />
				</div>
			</div>

			<br>

			<div class="control-group">
				<label class="control-label<?php validateField("gender", $missingFields)?>">Your gender :</label>
				<div class="controls">
					<input type="radio" name="gender" id="genderMale" value="m"<?php setChecked($member, "gender", "m")?> />
					Male <br>
					<input type="radio" name="gender" id="genderFemale" value="f"<?php setChecked($member, "gender", "f")?> />
					Female
				</div>
			</div>
			<!--End of Name & Gender-->

			<br>

			<div>
				<input class="btn btn-primary offset2 span2" type="submit" name="submitButton" id="submitButton" value="Send Details" />
				<input class="btn btn-info span2" type="reset" name="resetButton" id="resetButton" value="ResetForm" style="margin-right: 20px;" />
			</div>

		</div>
	</form>
	<?php
	displayPageFooter();
}


function processForm() {
	$requiredFields = array("username", "password", "emailAddress", "firstName", "lastName", "gender");
	$missingFields = array();
	$errorMessages = array();

	$member = new Member(array(
		"username"=>isset($_POST["username"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"]) : "",
		"password"=>(isset($_POST["password1"]) and isset($_POST["password2"]) 
			and $_POST["password1"] == $_POST["password2"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["password1"]) : "",
		"emailAddress"=>isset($_POST["emailAddress"]) ? preg_replace("/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["emailAddress"]) : "",
		"firstName"=>isset($_POST["firstName"]) ? preg_replace("/[^ \'\.\-a-zA-Z0-9]/", "", $_POST["firstName"]) : "",
		"lastName"=>isset($_POST["lastName"]) ? preg_replace("/[^ \'\-a-zA-Z0-9]/", "", $_POST["lastName"]) : "",
		"gender"=>isset($_POST["gender"]) ? preg_replace("/[^mf]/", "", $_POST["gender"]) : "",
		"joinDate" => date("Y-m-d")
		));

	foreach ($requiredFields as $requiredField) {
		if(!$member->getValue($requiredField)) {
			$missingFields[] = $requiredField;
		}
	}
	//print_r($missingFields);

	if($missingFields) {
		$errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resent the form.</p>';
	}

	if(!isset($_POST["password1"]) or !isset($_POST["password2"]) or !$_POST["password1"] or !$_POST["password2"] or ($_POST["password1"] != $_POST["password2"])) {
		$errorMessages[] = '<p class="error">Please make sure you enter your password correctly in both password fields.</p>';
	}

	if(Member::getByUsername ($member->getValue("username"))) {
		$errorMessages[] = '<p class="error">A member with that username already exists in the database. Please choose another username.</p>';
	}

	if(Member::getByEmailAddress ($member->getValue("emailAddress"))) {
		$errorMessages[] = '<p class="error">A member with that email address already exists in the database. Please choose another email address, or contact the webmaster to retrieve your password.</p>';
	}

	if($errorMessages) {
		displayForm($errorMessages, $missingFields, $member);
	} else {
		$member->insert();
		displayThanks();
	}
}

function displayThanks() {
	displayPageHeader("Thanks for registering!");
	?>
	<p>Thank you, you are now a registered.</p>
	<p>Go to the <a class="btn btn-primary" href="login.php">Login Page</a></p>
	<?php
	displayPageFooter();
}?>