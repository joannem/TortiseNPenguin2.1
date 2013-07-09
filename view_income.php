<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Income.class.php"); 

function displayIncome() {

	$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
	$order = isset($_GET["order"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["order"]) : "startDate";
	$id = $_SESSION["member"]->getValue("id");
	list($incomes, $totalRows) = Income::getIncomes($start, PAGE_SIZE, $order, $id);

	?>

	<h2>Income   <a class="btn btn-small" href="addIncome.php"><i class="icon-plus"></i>Add</a></h2>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th><?php if ($order != "startDate") { ?>
					<a href="UserHome.php?view=income&order=startDate"><?php } ?>From<?php if($order != "startDate") {?></a>
					<?php }?></th>
				<th><?php if ($order != "endDate") { ?>
					<a href="UserHome.php?view=income&order=endDate"><?php } ?>To<?php if($order != "endDate") {?></a>
					<?php }?></th>
				<th><?php if ($order != "type") { ?>
					<a href="UserHome.php?view=income&order=type"><?php } ?>Type<?php if($order != "type") {?></a>
					<?php }?></th>
				<th><?php if ($order != "incomeAmt") { ?>
					<a href="UserHome.php?view=income&order=incomeAmt"><?php } ?>Income<?php if($order != "incomeAmt") {?></a>
					<?php }?></th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($incomes as $income) {
				?>
				<tr>
					<?php $date = strtotime($income->getValueEncoded("startDate")); ?>
					<td><?php echo date('d', $date) . ' ' . getMonth(date('m', $date))  . ' ' . date('Y', $date)?></td>
					<?php $date = strtotime($income->getValueEncoded("endDate")); 
						if($date == "") {
							$date = strtotime(date('Y-m-d'));
						}
					?>
					<td><?php echo date('d', $date) . ' ' . getMonth(date('m', $date))  . ' ' . date('Y', $date)?></td>
					<td><?php echo $income->getValueEncoded("type")?></td>
					<td><?php  printf("$%.2f", $incomeAmount = floatval($income->getValueEncoded("incomeAmt"))) ?> </td>
					<td><a href="editIncome.php?incomeId=<?php echo $income->getValueEncoded("incomeId") ?>&amp;start=<?php echo $start ?>&amp; order=<?php echo $order ?>" class="btn btn-small"><i>edit</i></a></td>
				</tr>

				<?php

			}?>

		</tbody>
	</table>

	<h5>Displaying income <?php echo $start + 1?> - <?php echo min($start + PAGE_SIZE, $totalRows) ?> of <?php echo $totalRows ?></h5>

	<div style="width: 30em; margin-top: 20px; text-align: center;">
		<?php if($start> 0) { ?>
		<a href="UserHome.php?view=income&start=<?php echo max($start - PAGE_SIZE, 0) ?>&amp;order=<?php echo $order ?>">Previous page</a>
		<?php
	}?>
	&nbsp;
	<?php 
	if ($start + PAGE_SIZE <  $totalRows) { ?>
		<a href="UserHome.php?view=income&start=<?php echo min($start + PAGE_SIZE, $totalRows) ?>&amp;order=<?php echo $order ?> ">Next page</a>
		<?php 
	} ?>
	</div>

<?php 
	
} 

?>