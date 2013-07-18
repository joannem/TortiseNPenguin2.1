<?php

require_once("common.inc.php");
require_once("graphs/categories_O.php");
require_once("graphs/periods_O.php");
require_once("graphs/periods_C.php");

function displayOverview_noT() {
	$id = $_SESSION["member"]->getValue("id");
	$array = array('memberId'=> $id);
	$expenditure = new Expenditure($array);
	$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));
	?>

	<h2>Overview</h2>
	<div class="tabbable tabs-left">

		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">Overall</a></li>
			<li><a href="#tab2" data-toggle="tab">By Category</a></li>
			<li><a href="#tab3" data-toggle="tab">Over Time</a></li>
		</ul>

		<div class="tab-content">
			<!--Start Overall-->
			<div class="tab-pane active" id="tab1">
				<div class="span12">
					<h3>Overall</h3>
					<script type="text/javascript">
					var dataOL = <?php getPieData() ?>;
					var expendituresO = <?php getExData() ?>;
					var incomesO = <?php getInData() ?>;
					var savingsO = <?php getSavData() ?>;
					</script>
				</div>
				<div class="span6">
					<p><b>All exenditures, incomes and savings over time:</b></p>
					<div id="OvLineGraph" style="height: 300px; width: 500px; position: relative;" class="jqplot-target"></div>
					<br>
				</div>
				<div style="height: 215px; width: 229px; position: relative;"></div>
				<div class="offset1 span3 well" id="O_Checkboxes">
					<label class="checkbox">
						<input id="check_Ex" type="checkbox" name="O_Line" value="Expenditures">Expenditures<br>
						<input id="check_In" type="checkbox" name="O_Line" value="Incomes">Incomes<br>
						<input id="check_Sav" type="checkbox" name="O_Line" value="Savings">Savings<br>
					</label>
					<button class="btn btn-info" onclick=processCheckO()>Plot</button>
				</div>
				<br><br>
				<div class="span9">
					<p><b>All expenditures by category:</b></p>
					<button class="btn btn-info" onclick=drawChart_O(dataOL)>Show Pie Chart</button>
					<!--<script type="text/javascript"> drawChart(data); </script>-->
					<div id="OvPieChartDivId" style="margin-top:20px; margin-left:20px; width:600px; height:300px;"></div>
				</div>
			</div> <!--End Overall-->

			<!--Start Category-->
			<div class="tab-pane" id="tab2">
				<div class="span12">
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
							<button class="btn btn-info" style="margin-left: 10px;" onclick=processSelectAJAX((document.getElementById("sel_From").options[document.getElementById("sel_From").selectedIndex].value),(document.getElementById("sel_To").options[document.getElementById("sel_To").selectedIndex].value))>Filter</button>
						</p>		
						<!--<p>AJAX Response: <div id="txtHint"></div></p> (for debugging)-->
						<div id="PieChartDivId" style="margin-top:20px; margin-left:20px; width:600px; height:300px;"></div>
					</div>
			</div><!--End Category-->

			<!--Start over time-->
			<div class="tab-pane" id="tab3">
				<div class="span12">
					<h3>Over Time</h3>	
					<div class="span6">
						<p><b>All exenditures, incomes and savings over time:</b></p>
						<div id="CatLineGraph" style="height: 300px; width: 500px; position: relative;" class="jqplot-target"></div>
						<br>
					</div>
					<div style="height: 100px; width: 229px; position: relative;"></div>
					<div class="offset1 span3 well" id="Checkboxes">
						<label class="checkbox">
							<?php 
							foreach ($categories as $category) { ?>
								<input id="<?php echo $category ?>" type="checkbox" name="Line" value="<?php echo $category ?>"><?php echo $category ?><br>
							<?php 
							} ?>
						</label>
						<script type="text/javascript">
							var categories = <?php echo json_encode($categories) ?>;
							//console.log(categories);
							var categoriesData = <?php getCatData($categories) ?>;
							//console.log("before convert data: ");
							//console.log(categoriesData);
						</script>
						<button class="btn btn-info" onclick=processCheckC()>Plot</button>
					</div>
				</div>
			</div><!--End Overtime-->
		</div>

	</div>

<?php 
}
?>