<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Expenditure.class.php");
require_once("Income.class.php");

function displayOverview() {
	?>
	<h2>Overview</h2>
	
	<div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">Overall</a></li>
			<li><a href="#tab2" data-toggle="tab">By category</a></li>
			<li><a href="#tab3" data-toggle="tab">Over time</a></li>
		</ul>
		<div class="tab-content">

			<!--Start Overall-->
			<div class="tab-pane active" id="tab1">
				<h3>Overall</h3>
				<p>All exenditures over time:</p>
				<iframe src="graphs/line.html" marginwidth="0" marginheight="0" scrolling="no"></iframe>
				<p>All expenditures by category:</p>
				<iframe src="graphs/pie.html" marginwidth="0" marginheight="0" scrolling="no"></iframe>
			</div> <!--End Overall-->

			<!--Start Category-->
			<div class="tab-pane" id="tab2">
				<h3>By Category</h3>
					<form class="form-inline" action="UserHome.php?view=overview" method="post">
						<b>Filter: </b>show expenditures between
							<!--start Select From: -->
							<select class="span2" name="from">
								<option value='All'>All</option>
								<?php //UserHome.php?view=overview
								for ($year=2011; $year < 2014; $year++) { 
									for($month=1; $month < 13; $month++) {
										$from = $year . '-' . $month . '-01';
										echo '<option value=' . $from . '>' . getMonth($month) . '/' . $year . '</option>'; 
									}
								} ?>
							</select> <!--start Select From: -->
							and 
							<!--start Select To: -->
							<select class="span2" name="to">
								<option value='All'>All</option>
								<?php 
								for ($year=2011; $year < 2014; $year++) { 
									for($month=1; $month < 13; $month++) {
										$to = $year . '-' . $month . '-01';
										echo '<option value=' . $to . '>' . getMonth($month) . '/' . $year . '</option>'; 
									}
								} ?>
							</select><!--start Select To: -->.
							<!--"filter" submit button-->
							<input class="btn btn-small" type="submit" value="Submit" style="margin-left: 5px;">
					</form>
					<iframe src="graphs/pie.html" marginwidth="0" marginheight="0" scrolling="no"></iframe>
				
			</div><!--End Category-->

			<!--Start over time-->
			<div class="tab-pane" id="tab3">
				Overtime: show by monthly, yearly, weekly; checkboxes to choose which category u want to show
				<ul>
					<li><b>Line: </b>Savings</li>
					<li><b>Line: </b>Expenditure</li>
				</ul>				
			</div><!--End Overtime-->
		</div>
	</div>

<?php 
}
?>