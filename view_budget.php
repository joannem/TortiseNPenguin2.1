<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Budget.class.php");
require_once("Expenditure.class.php");

function displayBudget($success) {

	$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
	$order = isset($_GET["order"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["order"]) : "category";
	$id = $_SESSION["member"]->getValue("id");
	list($budgets, $totalRows) = Budget::getBudgets($start, PAGE_SIZE, $order, $id);
	//print_r($success);
	if($success == "success") {
		displaySuccess();
	} ?>
	<h2>Budget   <a class="btn btn-small" href="addBudget.php?start=<?php echo $start ?>&amp; order=<?php echo $order ?>"><i class="icon-plus"></i>Add</a></h2>

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
					<th><?php if ($order != "amtSpent") { ?>
					<a href="UserHome.php?view=budget&order=budgetAmt"><?php } ?>Spent<?php if($order != "amtSpent") {?></a>
					<?php }?></th>
				<th><?php if ($order != "amtLeft") { ?>
					<a href="UserHome.php?view=budget&order=budgetAmt"><?php } ?>Amt Left<?php if($order != "amtLeft") {?></a>
					<?php }?></th> <!--FIX THIS ONE, needs to be sorted using javascript-->
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($budgets as $budget) {
				$budgetAmt = floatval($budget->getValueEncoded("budgetAmt"));
				$amtSpent = Expenditure::getExpenditures_B($budget, $id) + 0.0;
				$chart_id = "bud_" . $budget->getValueEncoded("budgetId");
				?>
				<tr>
					<td><div style="height: 15px;"></div><?php echo $budget->getValueEncoded("category") ?></td>
					<td><div style="height: 15px;"></div><?php $year = $budget->getValueEncoded("startYear"); 
						if($year==0) { echo 'Forever'; } else { echo $year . '/' . getMonth($budget->getValueEncoded("startMonth")); }?> </td>
					<td><div style="height: 15px;"></div><?php $year = $budget->getValueEncoded("endYear"); 
						if($year==0) { echo 'Forever'; } else { echo $year . '/' . getMonth($budget->getValueEncoded("endMonth")); }?> </td>
					<td>
						<script type="text/javascript">
							var chart_id = "" + <?php echo json_encode($chart_id )?>;
							var budgetAmt = <?php echo $budgetAmt ?>;
							var amtSpent = <?php echo $amtSpent ?>;				
							var amtLeft = <?php echo $budgetAmt-$amtSpent ?>;
						</script>
						<div id="<?php echo $chart_id ?>" style="height: 50px; width: 450px; position: relative;" class="jqplot-target"></div>
						<script type="text/javascript">drawBar(budgetAmt,amtSpent,amtLeft,chart_id);</script>
					</td>
					<td><div style="height: 15px;"></div><?php  printf("$%.2f", $budgetAmt) ?> </td>
					<td><div style="height: 15px;"></div><?php  printf("$%.2f", $amtSpent) ?> </td>
					<td><div style="height: 15px;"></div><?php  printf("$%.2f", $budgetAmt-$amtSpent) ?> </td>
					<td><div style="height: 15px;"></div><a href="editBudget.php?budgetId=<?php echo $budget->getValueEncoded("budgetId") ?>&amp;start=<?php echo $start ?>&amp; order=<?php echo $order ?>" class="btn btn-small"><i>edit</i></a></td>
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