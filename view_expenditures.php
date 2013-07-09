<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Expenditure.class.php");

function displayExpenditures() {
	
	$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
	$order = isset($_GET["order"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["order"]) : "purchaseDate";
	$id = $_SESSION["member"]->getValue("id");
	list($expenditures, $totalRows) = Expenditure::getExpenditures($start, PAGE_SIZE, $order, $id);

	?>
	<!--target="_blank" add next time-->
	<h2>Expenditures  <a class="btn btn-small" href="addExpenditure.php"><i class="icon-plus"></i>Add</a></h2>

	<div class="span12"><p><i>Input filter functions here:====================================</i></p></div>
	<!--Search Button-->
	<div class="input-append" style="float: right;">
		<input class="span9" id="appendedInputButton" type="text" placeholder="this doesn't work yet">
		<button class="btn" type="button">Search</button>
	</div>

	<div>
		<h5>Total expenses: <?php 
		$TotalExpenditure = Expenditure::getTotalExpenditure($id);
		if($TotalExpenditure) {
			printf("$%.2f", floatval($TotalExpenditure));
		} else {
			echo 'cannot display value';
		} ?></h5>
	</div>

	<table class="table table-condensed">
		<thead>
			<tr>
				<th><?php if ($order != "purchaseDate") { ?> 
					<a href="UserHome.php?view=expenditure&order=purchaseDate"><?php } ?>Date purchased<?php if($order != "purchaseDate") {?></a>
					<?php }?>
				</th>
				<th><?php if ($order != "item") { ?> 
					<a href="UserHome.php?view=expenditure&order=item"><?php } ?>Item<?php if($order != "item") {?></a>
					<?php }?>
				</th>
				<th>Description</th>
				<th><?php if ($order != "category") { ?> 
					<a href="UserHome.php?view=expenditure&order=category"><?php } ?>Category<?php if($order != "category") {?></a>
					<?php }?>
				</th>
				<th><?php if ($order != "cost") { ?> 
					<a href="UserHome.php?view=expenditure&order=cost"><?php } ?>Cost<?php if($order != "cost") {?></a>
					<?php }?>
				</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>

			<?php
			foreach ($expenditures as $expenditure) {
				?>
				<tr>
					<?php $date = strtotime($expenditure->getValueEncoded("purchaseDate")); ?>
					<td><?php echo date('d', $date) . ' ' . getMonth(date('m', $date))  . ' ' . date('Y', $date)?></td>
					<td><?php echo $expenditure->getValueEncoded("item") ?> </td>
					<td><?php echo $expenditure->getValueEncoded("description") ?> </td>
					<td><?php echo $expenditure->getValueEncoded("category") ?> </td>
					<td><?php  printf("$%.2f", $expenditure->getValueEncoded("cost")) ?> </td>
					<td><a href="editExpenditure.php?itemId=<?php echo $expenditure->getValueEncoded("itemId") ?>&amp;start=<?php echo $start ?>&amp; order=<?php echo $order ?>" class="btn btn-small"><i>edit</i></a></td>
				</tr>

				<?php

			}?>

		</tbody>

	</table>

	<h5>Displaying expenditures <?php echo $start + 1?> - <?php echo min($start + PAGE_SIZE, $totalRows) ?> of <?php echo $totalRows ?></h5>

	<div style="width: 30em; margin-top: 20px; text-align: center;">
		<?php if($start> 0) { ?>
		<a href="UserHome.php?view=expenditure&start=<?php echo max($start - PAGE_SIZE, 0) ?>&amp;order=<?php echo $order ?>">Previous page</a>
		<?php
	}?>
	&nbsp;
	<?php 
	if ($start + PAGE_SIZE <  $totalRows) { ?>
		<a href="UserHome.php?view=expenditure&start=<?php echo min($start + PAGE_SIZE, $totalRows) ?>&amp;order=<?php echo $order ?> ">Next page</a>
		<?php 
	} ?>
	</div>

<?php 

} 

?>
