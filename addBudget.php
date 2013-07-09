<?php

#to add a new budget to the database
require_once("Budget.class.php");
require_once("Expenditure.class.php");
require_once("common.inc.php");

checkLogin();

?>

<?php


if(isset($_POST["action"]) and $_POST["action"] == "add") {
	processForm();
} else {
	displayForm(array(), array(), new Budget(array()));
}

function displayForm($errorMessages, $missingFields, $budget) {
	displayFormHeader("Add Budget");
	$id = $_SESSION["member"]->getValue("id");
	?>

	<h2>Add budget:</h2>
	<?php 

	if($errorMessages) {
		foreach ($errorMessages as $errorMessage) {
			echo $errorMessage;
		}
	}	?>

	<p>Please fill up all fields.</p>
	<form class="form-horizontal" action="addBudget.php" method="post">
		<div style="width: 50em;">
			<input type="hidden" name="action" value="add" />
			<input type="hidden" name="memberId" value="<?php echo $id ?>" /> <!--temporary cos login function hasn't been set up yet-->

			<!--start categroy-->
			<div class="control-group">
				<?php $expenditure = new Expenditure(array()); #obtain list of categories from expenditure not budget?>
				<label class="control-label<?php validateField("category", $missingFields)?>" for="category">Category :</label>
				<div class="controls">
					<select name="category" id="category" size="1">
						<?php foreach ($expenditure->listCategories($id) as $value => $label) { ?>
						<option value="<?php echo $label ?>"<?php setSelected ($budget, "category", $label) ?>><?php echo $label ?></option>
						<?php } ?>
					</select>
				</div>
			</div> <!--end category-->

			<!--start budgetAmt-->
			<div class="control-group">
				<label class="control-label<?php validateField("budgetAmt", $missingFields)?>" for="budget">Budget :</label>
				<div class="controls">
					<input type="text" name="budgetAmt" id="budgetAmt" value="<?php echo $budget->getValueEncoded("budgetAmt")?>" />
				</div>
			</div> <!--end budgetAmt-->

			<!--start Period-->
			<div class="control-group">
				<label class="control-label<?php validateField("period", $missingFields)?>">Period :</label>
				<div class="controls">
					<input class="radio" type="radio" name="period" id="choosePeriod" value="choose" <?php setChecked($budget, "period", "choose")?>>
					Select period to track budget for (dates must be different): <br>
				<div> <!--wraps around select options-->
					<?php $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
					#sorry, hardcoding this for now
					?>

					<!--from:-->
					From: 					
					<select class="span2" name="startMonth" id="startMonth" size="1" style="margin: 4px 5px 3px 33px;">
						<?php
						foreach ($months as $num => $name) { ?>
						<option value="<?php echo $num ?>"<?php setSelected($budget, "startMonth", $num)?>><?php echo $name ?></option>
						<?php } ?></select> 

					<select class="span2" name="startYear" id="startYear" size="1" style="margin: 4px 5px 3px 5px;">
						<?php 
						$thisYear = date('Y');
						for ($year=$thisYear; $year > $thisYear-50 ; $year--) { ?>
						<option value="<?php echo $year ?>"<?php setSelected ($budget, "startYear", $year) ?>><?php echo $year ?></option>
						<?php } ?></select> <br>

					<!--to:-->	
					To before:
					<select class="span2" name="endMonth" id="endMonth" size="1" style="margin: 4px 5px 3px 8px;">
						<?php
						foreach ($months as $num => $name) { ?>
						<option value="<?php echo $num ?>"<?php setSelected($budget, "endMonth", $num)?>><?php echo $name ?></option>
						<?php } ?></select>
					
					<select class="span2" name="endYear" id="endYear" size="1" style="margin: 4px 5px 3px 5px;">
						<?php 
						for ($year=$thisYear; $year > $thisYear-50 ; $year--) { ?>
						<option value="<?php echo $year ?>"<?php setSelected ($budget, "endYear", $year) ?>><?php echo $year ?></option>
						<?php } ?></select> <br>
				</div> <!--end of select options-->
				<!--forever-->
				<input class="radio" type="radio" name="period" id="foreverPeriod" value="forever" <?php setChecked($budget, "period", "forever")?>>
						Forever	
				</div>
			</div> <!--end Period-->

			<br>
			<br>
			<br>

			<!--submission buttons-->
			<div>
				<input class="btn btn-primary offset2 span2" type="submit" name="submitButton" id="submitButton" value="Send Details" style="margin-right: 8px;"/>
				<input class="btn btn-info span2" type="reset" name="resetButton" id="resetButton" value="Reset Form"  />
				<br>
				<br>
				<a href="UserHome.php?view=budget" class="btn btn-small offset3">Back</a>
			</div>

		</div>
	</form>

		<?php 			
		displayPageFooter();
	}

	function processForm() {
		$requiredFields = array("category", "budgetAmt", "period");
		$missingFields = array();
		$errorMessages = array();

		#settle forever options; '0' for years means 'forever'
		if(isset($_POST["period"]) && ($_POST["period"] == "forever")) {
			$_POST["startMonth"] = 1;
			$_POST["startYear"] = 0;
			$_POST["endMonth"] = 12;
			$_POST["endYear"] = 0;
		} 

		$budget = new Budget(array(
			"memberId"=>isset($_POST["memberId"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["memberId"]) : "",
			"budgetAmt"=>isset($_POST["budgetAmt"]) ? preg_replace("/[^\'\.\-_a-zA-Z0-9]/", "", $_POST["budgetAmt"]) : "",
			"category"=>isset($_POST["category"]) ? preg_replace("/[^a-zA-Z]/", "", $_POST["category"]) : "",
			"startMonth"=>isset($_POST["startMonth"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["startMonth"]) : "",
			"startYear"=>isset($_POST["startYear"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["startYear"]) : "",
			"endMonth"=>isset($_POST["endMonth"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["endMonth"]) : "",
			"endYear"=>isset($_POST["endYear"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["endYear"]) : "",
			"period"=>isset($_POST["period"]) ? preg_replace("/[^a-zA-Z]/", "", $_POST["period"]) : ""
			));
			#print_r($budget); #for debugging

		/***Handling mistakes***/
		foreach ($requiredFields as $requiredField) {
			if(!$budget->getValue($requiredField)) {
				$missingFields[] = $requiredField;
			}
		}

		#Fields not filled in
		if($missingFields || !isset($_POST["period"])) {
			#print_r($budget);
			#print_r($missingFields);
			$errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resent the form.</p>';
		}

		#Chekcs if budget a correct value for float
		$floatPat = "~^[0-9]+(\.[0-9]+)?$~";
		if(!preg_match($floatPat, $budget->getValue("budgetAmt"))) {
			$errorMessages[] = '<p class="error">Invalid value for "Budget" was entered. Only numerical digits are allowed. (eg. 100, 0.90, 5.43)</p>';
		}

		#checks if period of from-to is selected correctly
		if(isset($_POST["period"]) && $_POST["period"] != "forever") {
			if ( ((int)$_POST["endYear"] < (int)$_POST["startYear"]) ||
				((int)$_POST["endYear"] == (int)$_POST["startYear"]) && ((int)$_POST["endMonth"] <= (int)$_POST["startMonth"])) {
				$errorMessages[] = '<p class="error">' . getMonth($_POST["endMonth"]) . ' ' . $_POST["endYear"] . ' is before or the same as ' . getMonth($_POST["startMonth"]) .' ' . $_POST["startYear"] . '!</p>';
			}
		}

		if($errorMessages) {
			displayForm($errorMessages, $missingFields, $budget);
		} else {
			$budget->insert();
			displayThanks();
		}
	}

		function displayThanks() {
			displayFormHeader("Add Budget-Success");
			?>
			<p>Response Submitted. :)</p>
			<div class="offset3 span 6">
				<a href="UserHome.php?view=budget" class="btn">Return to Home</a>
			</div>
			<?php
			displayPageFooter();
		} ?>