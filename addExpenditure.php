<?php

#to add a new expense to the database
require_once("common.inc.php");

checkLogin();

if(isset($_POST["action"]) and $_POST["action"] == "add") {
	processForm();
} else {
	displayForm(array(), array(), new Expenditure(array()));
}

function displayForm($errorMessages, $missingFields, $expenditure) {
	displayFormHeader("Add Expenditure");
	$id = $_SESSION["member"]->getValue("id");
	?>

	<h2>Add expenditure:</h2>
	<?php 

	if($errorMessages) {
		foreach ($errorMessages as $errorMessage) {
			echo $errorMessage;
		}
	}	?>

		<p>Fields marked with an asterisk (*) are required.</p>
		<form class="form-horizontal" action="addExpenditure.php" method="post">
			<div style="width: 50em;">
				<input type="hidden" name="action" value="add" />
				<input type="hidden" name="memberId" value="<?php echo $id ?>" />

				<!--Start Item-->
				<div class="control-group">
					<label class="control-label<?php validateField("item", $missingFields)?>" for="item">Item *:</label>
					<div class="controls">
						<input type="text" name="item" id="item" value="<?php echo $expenditure->getValueEncoded("item")?>" />
					</div>
				</div> <!--End Item-->

				<!--Start Cost-->
				<div class="control-group">
					<label class="control-label<?php validateField("cost", $missingFields)?>" for="cost">Cost *:</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on">$</span>
							<input class="span12" type="text" name="cost" id="cost" value="<?php echo $expenditure->getValueEncoded("cost")?>" />
						</div>
					</div>
				</div> <!--End Cost-->

				<!--Start Description-->
				<div class="control-group">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea name="description" id="description" rows="4" cols="50"><?php echo $expenditure->getValueEncoded("description")?></textarea>
					</div>
				</div> <!--End Description-->

				<!--Start Categories-->
				<div class="control-group">
					<label class="control-label<?php validateField("category", $missingFields)?>" for="category">Category *:</label>
					<div class="controls">
						<select name="category" id="category" size="1">
							<?php $listCategories = $expenditure->listCategories($id);
								foreach ($listCategories as $value => $label) { ?>
							<option value="<?php echo $label ?>"<?php setSelected ($expenditure, "category", $label) ?>><?php echo $label ?></option>
							<?php } 
							if(!in_array("Others", $listCategories)) { ?>
								<option value="Others"<?php setSelected ($expenditure, "category", "Others") ?>>Others</option>
							<?php } ?>
							<option value=""<?php setSelected ($expenditure, "category", "") ?>>Add new category</option>
						</select>
						<br>
						<br>
						<input type="text" name="newCategory" id="newCategory" value="<?php if(isset($_POST["newCategory"])) echo $_POST["newCategory"]?>" placeholder="Create New Category (fill only when required)" />
					</div>
				</div> <!--End categories-->

				<!--Start date purchased-->
				<div class="control-group">
					<label class="control-label" for="purchaseDate">Date Purchased *:</label>
					<div class="controls">
						<!--Day-->
						<select class="span2" name="purchaseDay" id="purchaseDay" size="1">
							<?php for ($day=1; $day<32 ; $day++) { ?>
							<option value="<?php echo $day ?>"<?php setArrSelected ($_POST, "purchaseDay", $day) ?>><?php echo $day ?></option>
							<?php } ?></select>

						<!--Month-->
						<?php $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
						?>
						<select class="span2" name="purchaseMonth" id="purchaseMonth" size="1">
							<?php
							foreach ($months as $num => $name) { ?>
							<option value="<?php echo $num ?>"<?php setArrSelected($_POST, "purchaseMonth", $num)?>><?php echo $name ?></option>
						<?php } ?></select>

						<!--Year-->
						<select class="span2" name="purchaseYear" id="purchaseYear" size="1">
							<?php 
							$thisYear = date('Y');
							for ($year=$thisYear; $year > $thisYear-50 ; $year--) { ?>
							<option value="<?php echo $year ?>"<?php setArrSelected ($_POST, "purchaseYear", $year) ?>><?php echo $year ?></option>
							<?php } ?></select>
					</div>
				</div> <!--End date purchased-->

				<div>
					<input class="btn btn-primary offset2 span2" type="submit" name="submitButton" id="submitButton" value="Send Details" style="margin-right: 8px;" />
					<input class="btn btn-info span2" type="reset" name="resetButton" id="resetButton" value="Reset Form" />
					<br>
					<br>
					<a href="UserHome.php?view=expenditure" class="btn btn-small offset3">Back</a>
				</div>

			</div>
		</form>

			<?php 			
			displayPageFooter();
		}

		function processForm() {
			$requiredFields = array("item", "cost", "category", "purchaseDate");
			$missingFields = array();
			$errorMessages = array();

			#create date value in YYYY-MM-DD format
			$date = "'" . $_POST["purchaseYear"] . "-" . $_POST["purchaseMonth"] . "-" . $_POST["purchaseDay"] . "'";

			#settle new or old category conflict
			if(($_POST["category"] == "") && isset($_POST["newCategory"])) {
				$category = $_POST["newCategory"];
			} else {
				$category = $_POST["category"]; #default value of 'category' if both values are filled in
			}

			$expenditure = new Expenditure(array(
				"item"=>isset($_POST["item"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["item"]) : "",
				"cost"=>isset($_POST["cost"]) ? preg_replace("/[^\'\.\-_a-zA-Z0-9]/", "", $_POST["cost"]) : "",
				"description"=>isset($_POST["description"]) ? preg_replace("/[^ \'\,\.\-a-zA-Z0-9']/", "", $_POST["description"]) : "",
				"category"=>isset($category) ? preg_replace("/[^a-zA-Z]/", "", $category) : "",
				"purchaseDate"=>isset($date) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $date) : "",
				"memberId"=>isset($_POST["memberId"]) ? preg_replace("/[^\-\_a-zA-Z0-9]/", "", $_POST["memberId"]) : ""
				));
			#print_r($expenditure); #for debugging

			foreach ($requiredFields as $requiredField) {
				if(!$expenditure->getValue($requiredField)) {
					$missingFields[] = $requiredField;
				}
			}

			if($missingFields) {
				$errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resent the form.</p>';
			}

			$floatPat = "~^[0-9]+(\.[0-9]+)?$~";
			if(!preg_match($floatPat, $expenditure->getValue("cost"))) {
				$errorMessages[] = '<p class="error">Invalid value for "Cost" was entered. Only numerical digits are allowed. (eg. 100, 0.90, 5.43)</p>';
			}
			if (($_POST["category"] != "") && ($_POST["newCategory"] != "")) {
				$errorMessages[] = '<p class="error">Each item can only belong to one category. Please choose either ' . $_POST["category"] . ' or ' . $_POST["newCategory"] . '.</p>';
			}


			if($errorMessages) {
				displayForm($errorMessages, $missingFields, $expenditure);
			} else {
				$expenditure->insert();
				displayThanks();
			}
		}

		function displayThanks() {
			displayFormHeader("Add Expenditure-Success");
			?>
			<p>Response Submitted. :)</p>
			<div class="offset3 span 6">
				<a href="UserHome.php?view=expenditure" class="btn">Return to Home</a>
				<!-- add the order memorizing thing later-->
			</div>
			<?php
			displayPageFooter();
		} ?>