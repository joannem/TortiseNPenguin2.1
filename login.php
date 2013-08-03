<?php

require_once("common.inc.php");
require_once("Member.class.php");

session_start();

if(isset($_POST["action"]) and $_POST["action"] == "login")  {
	processForm();
} else {
	displayForm(array(), array(), new Member(array()));
}

function displayForm($errorMessages, $missingFields, $member) {
	displayLogHeader("Login");

	if($errorMessages) {
		foreach ($errorMessages as $errorMessage) {
			echo $errorMessage;
		}
	}  ?>

	<h3>Login:</h3>

	<form class="form-horizontal" action="login.php" method="post">
		<div style="width: 50em;">

			<input type="hidden" name="action" value="login" />

			<div class="control-group">
				<label class="control-label" for="username"<?php validateField("username", $missingFields)?>>Username</label>
				<div class="controls">
					<input type="text" name="username" id="username" value="<?php echo $member->getValueEncoded("username")?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="password"<?php if($missingFields) echo 'class="error"'?>>Password</label>
				<div class="controls">
					<input type="password" name="password" id="password" value="" />
				</div>
			</div>

			<br>
			<br>

			<div>
				<input class="btn btn-primary offset4 span2" type="submit" name="submitButton" id="submitButton" value="Login" />
			</div>

		</div>
	</form>
	<?php
		displayPageFooter();
}

function processForm() {
	$requiredFields = array("username", "password");
	$missingFields = array();
	$errorMessages = array();

	$member = new Member(array(
		"username" => isset($_POST["username"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"]) : "",
		"password" => isset($_POST["password"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["password"]) : "",
		));

	foreach ($requiredFields as $requiredField) {
		if(!$member->getValue($requiredField)) {
			$missingFields[] = $requiredField;
		}
	}

	if($missingFields) {
		$errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Longin to resend the form.</p>';

	} elseif(!$loggedInMember = $member->authenticate()) {
		$errorMessages[] = '<p class="error">Sorry, incorrect login details entered. Please check your username and password, and try again.</p>';
	}

	if($errorMessages) {
		displayForm($errorMessages, $missingFields, $member);
	} else {
		$_SESSION["member"] = $loggedInMember;
		displayThanks();
	}
}

function displayThanks() { 
	?>
	<script type="text/javascript">
		window.location.replace('UserHome.php?&success=success')
	</script>
	<?php 
} ?>