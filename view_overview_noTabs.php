<?php

require_once("common.inc.php");
require_once("graphs/categories_O.php");

function displayOverview_noT() {
	?>

	<h2>Overview-noTabs</h2>

	<!--Start Overall-->
	<div>
		<h3>Overall</h3>
		<script type="text/javascript">
			var data = <?php getPieData() ?>;
				//document.write("data: <br>");
				//document.write(data);
		</script>
		<p><b>All exenditures over time:</b></p>
		<div id="chart1" style="height: 300px; width: 500px; position: relative;" class="jqplot-target"></div>
		<br><br>
		<p><b>All expenditures by category:</b></p>
		<button onclick=drawChart_O(data)>Show Pie Chart</button>
		<!--<script type="text/javascript"> drawChart(data); </script>-->
		<div id="OvPieChartDivId" style="margin-top:20px; margin-left:20px; width:600px; height:300px;"></div>
	</div> <!--End Overall-->

	<!--Start Category-->
	<div>
		<h3>By Category</h3>
		<p>
			<b>Filter: </b>show expenditures between
			<!--start Select From: -->
			<select style="margin-top: 5px;" class="span2" name="from" id="sel_From">
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
			<select style="margin-top: 5px;" class="span2" name="to" id="sel_To">
				<option value='All'>All</option>
				<?php 
				for ($year=2011; $year < 2014; $year++) { 
					for($month=1; $month < 13; $month++) {
						$to = $year . '-' . $month . '-01';
						echo '<option value=' . $to . '>' . getMonth($month) . '/' . $year . '</option>'; 
					}
				} ?>
			</select><!--start Select To: -->
			<!--"filter" submit button-->
			<button style="margin-left: 10px;" class="btn" onclick=processSelectAJAX((document.getElementById("sel_From").options[document.getElementById("sel_From").selectedIndex].value),(document.getElementById("sel_To").options[document.getElementById("sel_To").selectedIndex].value))>Filter</button></p>
			<!--<p>AJAX Response: <div id="txtHint"></div></p> (for debugging)-->
		<div id="PieChartDivId" style="margin-top:20px; margin-left:20px; width:600px; height:300px;"></div>
	</div><!--End Category-->

	<!--Start over time-->
	<div>
		<h3>Over Time</h3>
		 show by monthly, yearly, weekly; checkboxes to choose which category u want to show
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