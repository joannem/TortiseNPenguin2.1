<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Income.class.php");

checkLogin();

$incomeId = isset($_REQUEST["incomeId"]) ? (int)$_REQUEST["incomeId"] : 0;

$income = Income::getIncome($incomeId);

if(isset($_POST["action"]) and $_POST["action"] == "Save Changes") {
	saveBudget();
} elseif(isset($_POST["action"]) and $_POST["action"] == "Delete Record") {
	deleteBudget();
} else {
	displayForm(array(), array(), $income);

}

function displayForm($errorMessages, $missingFields, $income) {
	displayFormHeader("Edit Income");
	?>
	<h2>Edit income:</h2>
<?php 
	if($errorMessages) {
		foreach ($errorMessages as $errorMessage) {
			echo $errorMessage;
		}
	}

	$start = isset($_REQUEST["start"]) ? (int)$_REQUEST["start"] : 0;
	$order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z]/", "", $_REQUEST["order"]) : "purchaseDate";
	$id = $_SESSION["member"]->getValue("id");
	?>

	<p>Please fill up all fields. <br>
		<i style="color: orange;">If income is once-off, do not check 'Update this amount on this day every month', select 'specify date' under 'To: ' section, and pick the same date as 'From: '.</i>
	</p>
	<form class="form-horizontal" action="editIncome.php" method="post">
		<div style="width: 50em;">

			<input type="hidden" name="incomeId" id="incomeId" value="<?php echo $income->getValueEncoded("incomeId") ?>" />
			<input type="hidden" name="memberId" value="<?php echo $id ?>" />
			<input type="hidden" name="start" id="start" value="<?php echo $start ?>" />
			<input type="hidden" name="order" id="order" value="<?php echo $order ?>" />

			<!--start incomeAmt-->
			<div class="control-group">
				<label class="control-label<?php validateField("incomeAmt", $missingFields)?>" for="income">Income :</label>
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on">$</span>
						<input class="span12" type="text" name="incomeAmt" id="incomeAmt" value="<?php echo $income->getValueEncoded("incomeAmt")?>" />
					</div>
				</div>
			</div> <!--end incomeAmt-->

			<!--start startDate-->
			<div class="control-group">
				<label class="control-label" for="startDate">From :</label>
				<div class="controls">
					<?php 
						$prevSDate = strtotime($income->getValueEncoded("startDate"));
						$prevDay = date('d', $prevSDate);
						$prevMonth = date('m', $prevSDate);
						$prevYear = date('Y', $prevSDate);
						?>

					<!--Day-->
					<select class="span2" name="startDay" id="startDay" size="1">
						<?php for ($day=1; $day<32 ; $day++) { ?>
						<option value="<?php echo $day ?>"<?php if($day == $prevDay) { echo ' selected="selected"';}?>><?php echo $day ?></option>
						<?php } ?></select>

					<!--Month-->
					<?php $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'); ?>
					<select class="span2" name="startMonth" id="startMonth" size="1">
						<?php
						foreach ($months as $num => $name) { ?>
						<option value="<?php echo $num ?>"<?php if($num == $prevMonth) { echo ' selected="selected"';}?>><?php echo $name ?></option>
						<?php } ?></select>

					<!--Year-->
					<select class="span2" name="startYear" id="startYear" size="1">
						<?php 
						$thisYear = date('Y');
						for ($year=$thisYear; $year > $thisYear-50 ; $year--) { ?>
						<option value="<?php echo $year ?>"<?php if($year == $prevYear) { echo ' selected="selected"';} ?>><?php echo $year ?></option>
						<?php } ?></select>
					<br>
					<!--Type: -->
					<input class="checkbox" type="checkbox" name="type" id="monthly" value="monthly" <?php setChecked($income, "type", "monthly")?> style="margin-right: 5px;" onclick=CheckedSetSelect_In(document.getElementById("startDay").selectedIndex)>Update this amount on this day every month <br>
					<i>*Not selecting this option would mean that this income is once-off.</i>
				</div>
			</div> <!--End startDate-->

			<!--Start endDate-->
			<div class="control-group">
				<label class="control-label<?php validateField("endDate", $missingFields)?>" for="endDate">To :</label>
				<div class="controls">
					<?php 
						$prevEDate = strtotime($income->getValueEncoded("endDate"));
						$prevDay = date('d', $prevEDate);
						$prevMonth = date('m', $prevEDate);
						$prevYear = date('Y', $prevEDate);
						?>

					<!--specify date-->
					<input class="radio" type="radio" name="endDate" id="endDate_S" value="specified" <?php if($prevEDate != "0") { echo ' checked="checked"';}?> onclick=SetSelect_In(false)>			
					Specify Date: <br>
					<div> <!--Wraps around Select options-->
						<!--Day-->
						<select class="span2" name="endDay" id="endDay" size="1">
							<?php for ($day=1; $day<32 ; $day++) { ?>
							<option value="<?php echo $day ?>"<?php if($day == $prevDay) { echo ' selected="selected"';}?>><?php echo $day ?></option>
							<?php } ?></select>

						<!--Month-->
						<?php $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'); ?>
						<select class="span2" name="endMonth" id="endMonth" size="1">
							<?php
							foreach ($months as $num => $name) { ?>
							<option value="<?php echo $num ?>"<?php if($num == $prevMonth) { echo ' selected="selected"';}?>><?php echo $name ?></option>
							<?php } ?></select>

						<!--Year-->
						<select class="span2" name="endYear" id="endYear" size="1">
							<?php 
							$thisYear = date('Y');
							for ($year=$thisYear; $year > $thisYear-50 ; $year--) { ?>
							<option value="<?php echo $year ?>"<?php if($year == $prevYear) { echo ' selected="selected"';}?>><?php echo $year ?></option>
							<?php } ?></select> <br><br>
					</div> <!--end of select options-->

					<!--no specific date-->
					<input class="radio" type="radio" name="endDate" id="endDate_US" value="unspecified" <?php setChecked($income, "endDate", "0")?> onclick=SetSelect_In(true)>Till this moment	
				</div>
			</div> <!--end endDate-->

			<br>
			<br>
			<br>

			<!--submission buttons-->
			<div>
				<input class="btn btn-primary offset2 span3" type="submit" name="action" id="saveButton" value="Save Changes" style="margin-right: 8px;"/>
				<input class="btn btn-info span3" type="submit" name="action" id="deleteButton" value="Delete Record" />
				<br>
				<br>
				<a href="UserHome.php?view=income&start=<?php echo $start ?>&amp;order=<?php echo $order ?>" class="btn btn-small span2 offset4">Back</a>
			</div>

		</div>
	</form>

		<?php 
		displayPageFooter();
}

function saveBudget() {
		$requiredFields = array("incomeAmt", "startDate", "type");
		$missingFields = array();
		$errorMessages = array();

		#convert radio options into dates
		if(isset($_POST["endDate"]) && ($_POST["endDate"] == "unspecified")) {
			$endDate = 0;
		} else {
			if($_POST["type"] == "monthly") {
				$endDate = "'" . $_POST["endYear"] . "-" . $_POST["endMonth"] . "-" . $_POST["endDay"] . "'";
			} else {
				$endDate = "'" . $_POST["startYear"] . "-" . $_POST["startMonth"] . "-" . $_POST["startDay"] . "'";
			}
		}

		#create date value in YYYY-MM-DD format
		$startDate = "'" . $_POST["startYear"] . "-" . $_POST["startMonth"] . "-" . $_POST["startDay"] . "'";

		$income = new Income(array(
			"memberId"=>isset($_POST["memberId"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["memberId"]) : "",
			"incomeAmt"=>isset($_POST["incomeAmt"]) ? preg_replace("/[^\'\.\-_a-zA-Z0-9]/", "", $_POST["incomeAmt"]) : "",
			"type"=>isset($_POST["type"]) ? preg_replace("/[^\'\.\-_a-zA-Z0-9]/", "", $_POST["type"]) : "",
			"startDate"=>isset($_POST["startDay"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $startDate) : "",
			"endDate"=>isset($_POST["endDate"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $endDate) : ""
			));
		#	print_r($income); #for debugging

		/***Handling mistakes***/
		foreach ($requiredFields as $requiredField) {
			if(!$income->getValue($requiredField)) {
				$missingFields[] = $requiredField;
			}
		}
		if(!isset($_POST["endDate"])) {
			$missingFields[] = "endDate";
		}

		#Fields not filled in
		if($missingFields) {
			#print_r($income);
			#print_r($missingFields);
			$errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resent the form.</p>';
		}

		#Checks if income a correct value for float
		$floatPat = "~^[0-9]+(\.[0-9]+)?$~";
		if(!preg_match($floatPat, $income->getValue("incomeAmt"))) {
			$errorMessages[] = '<p class="error">Invalid value for "Income" was entered. Only numerical digits are allowed. (eg. 100, 0.90, 5.43)</p>';
		}

		#checks if period of from-to is selected correctly
		if(isset($_POST["endDate"]) && $_POST["endDate"] != "unspecified") {
			if ( ((int)$_POST["endYear"] < (int)$_POST["startYear"]) ||
				((int)$_POST["endYear"] == (int)$_POST["startYear"]) && ((int)$_POST["endMonth"] <= (int)$_POST["startMonth"])) {
				$errorMessages[] = '<p class="error">' . getMonth($_POST["endMonth"]) . ' '. $_POST["endYear"] . ' is before or the same as ' . getMonth($_POST["startMonth"]) . ' ' . $_POST["startYear"] . '!</p>';
			}
		}

		if($errorMessages) {
			displayForm($errorMessages, $missingFields, $income);
		} else {
			$income->insert();
			displayThanks();
		}
	}

function deleteBudget() {
	$income = new Income(array(
		"incomeId"=>isset($_POST["incomeId"]) ? (int)$_POST["incomeId"] : ""
		));
	#print_r($income);
	$income->delete();
	displaySuccess();
}

function displaySuccess() {
	$start = isset($_REQUEST["start"]) ? (int)$_REQUEST["start"] : 0;
	$order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z]/", "", $_REQUEST["order"]) : "purchaseDate";

	displayFormHeader("Changes Saved");
	?>
	<h2>Changes saved</h2>
	<p>Your changes have been saved.</p>
	<p><a href="UserHome.php?view=income&start=<?php echo $start ?>&amp;order=<?php echo $order ?>">Return to Incomes' list</a></p>

	<?php 
	displayPageFooter();
}