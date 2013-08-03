<?php

require_once("view_overview.php");
require_once("view_expenditures.php");
require_once("view_budget.php");
require_once("view_income.php");
require_once("view_member.php");

displayPageHeader();
$view = isset($_GET["view"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["view"]) : "overview";
$success = isset($_GET["success"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["success"]) : "";
?>

<div class="container-fluid">
	<div class="row-fluid"> 
		<?php 
		checkLogin();
		displaySideBar(); 
		$id = $_SESSION["member"]->getValueEncoded("id");
		?>

		<div class="span9">
			<ul class="nav nav-pills">
				<li <?php if($view == "overview") { echo 'class="active"'; } ?>><a href="UserHome.php?view=overview">Overview</a></li>
				<li <?php if($view == "expenditure") { echo 'class="active"'; } ?>><a href="UserHome.php?view=expenditure">Expenditures</a></li>
				<li <?php if($view == "budget") { echo 'class="active"'; } ?>><a href="UserHome.php?view=budget">Budget</a></li>
				<li <?php if($view == "income") { echo 'class="active"'; } ?>><a href="UserHome.php?view=income">Income</a></li>
				<li <?php if($view == "profile") { echo 'class="active"'; } ?>><a href="UserHome.php?view=profile&memberId=<?php echo $id ?>">Profile</a></li>
			</ul>

			<?php 
			if($view == "overview") {
				displayOverview($success);
			} elseif($view == "expenditure") {	
				displayExpenditures($success);
			} elseif($view == "budget") {
				displayBudget($success);
			} elseif ($view == "income") {
				displayIncome($success);
			} elseif ($view == "profile") {
				displayProfile();
			} else {
				echo 'error: file not found.';
			}
			 ?>

		</div>
	</div>
</div>

<?php displayPageFooter(); ?>

