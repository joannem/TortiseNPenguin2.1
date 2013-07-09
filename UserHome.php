<?php
require_once("view_expenditures.php");
require_once("view_overview.php");
require_once("view_budget.php");
require_once("view_income.php");

displayPageHeader();
$view = isset($_GET["view"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["view"]) : "overview";
?>

<div class="container-fluid">
	<div class="row-fluid"> 
		<?php 
		checkLogin();
		displaySideBar(); ?>

		<div class="span9">
			<ul class="nav nav-pills">
				<li <?php if($view == "overview") { echo 'class="active"'; } ?>><a href="UserHome.php?view=overview">Overview</a></li>
				<li <?php if($view == "expenditure") { echo 'class="active"'; } ?>><a href="UserHome.php?view=expenditure">Expenditures</a></li>
				<li <?php if($view == "budget") { echo 'class="active"'; } ?>><a href="UserHome.php?view=budget">Budget</a></li>
				<li <?php if($view == "income") { echo 'class="active"'; } ?>><a href="UserHome.php?view=income">Income</a></li>
			</ul>

			<?php 
			if($view == "expenditure") {
				displayExpenditures();
			} elseif($view == "overview") {
				displayOverview();
			} elseif($view == "budget") {
				displayBudget();
			} elseif ($view == "income") {
				displayIncome();
			} else {
				echo 'error: file not found.';
			}
			 ?>

		</div>
	</div>
</div>

<?php displayPageFooter(); ?>

