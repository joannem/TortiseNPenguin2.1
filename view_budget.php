<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Budget.class.php");
require_once("Expenditure.class.php");

function displayBudget() {

	$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
	$order = isset($_GET["order"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["order"]) : "category";
	$id = $_SESSION["member"]->getValue("id");
	list($budgets, $totalRows) = Budget::getBudgets($start, PAGE_SIZE, $order, $id);

	?>
	<!--target="_blank" add next time-->
	<h2>Budget   <a class="btn btn-small" href="addBudget.php"><i class="icon-plus"></i>Add</a></h2>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th><?php if ($order != "category") { ?> 
					<a href="UserHome.php?view=budget&order=category"><?php } ?>Category<?php if($order != "category") {?></a>
					<?php }?></th>
				<th><?php if ($order != "from") { ?>
					<a href="UserHome.php?view=budget&order=from"><?php } ?>From<?php if($order != "from") {?></a>
					<?php }?></th>
				<th><?php if ($order != "to") { ?>
					<a href="UserHome.php?view=budget&order=to"><?php } ?>To<?php if($order != "to") {?></a>
					<?php }?></th>
				<th>Indicator</th>
				<th><?php if ($order != "budgetAmt") { ?>
					<a href="UserHome.php?view=budget&order=budgetAmt"><?php } ?>Budget<?php if($order != "budgetAmt") {?></a>
					<?php }?></th>
				<th><?php if ($order != "category") { ?>
					<a href="UserHome.php?view=budget&order=category"><?php } ?>Amount Left<?php if($order != "category") {?></a>
					<?php }?></th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($budgets as $budget) {
				?>
				<tr>
					<td><?php echo $budget->getValueEncoded("category") ?></td>
					<td><?php $year = $budget->getValueEncoded("startYear"); 
						if($year==0) { echo 'Forever'; } else { echo $year . '/' . getMonth($budget->getValueEncoded("startMonth")); }?> </td>
					<td><?php $year = $budget->getValueEncoded("endYear"); 
						if($year==0) { echo 'Forever'; } else { echo $year . '/' . getMonth($budget->getValueEncoded("endMonth")); }?> </td>
					<td><i>insert graph here: <===================================></i></td>
					<td><?php  printf("$%.2f", $budgetAmount = floatval($budget->getValueEncoded("budgetAmt"))) ?> </td>
					<td><?php  printf("$%.2f", $budgetAmount-floatval(Expenditure::getExpenditures_B($budget, $id))) ?> </td>
					<td><a href="editBudget.php?budgetId=<?php echo $budget->getValueEncoded("budgetId") ?>&amp;start=<?php echo $start ?>&amp; order=<?php echo $order ?>" class="btn btn-small"><i>edit</i></a></td>
				</tr>

				<?php

			}?>

		</tbody>
	</table>

	<h5>Displaying budget <?php echo $start + 1?> - <?php echo min($start + PAGE_SIZE, $totalRows) ?> of <?php echo $totalRows ?></h5>

	<div style="width: 30em; margin-top: 20px; text-align: center;">
		<?php if($start> 0) { ?>
		<a href="UserHome.php?view=budget&start=<?php echo max($start - PAGE_SIZE, 0) ?>&amp;order=<?php echo $order ?>">Previous page</a>
		<?php
	}?>
	&nbsp;
	<?php 
	if ($start + PAGE_SIZE <  $totalRows) { ?>
		<a href="UserHome.php?view=budget&start=<?php echo min($start + PAGE_SIZE, $totalRows) ?>&amp;order=<?php echo $order ?> ">Next page</a>
		<?php 
	} ?>
	</div>

<?php 

} 

?>