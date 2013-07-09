<html>

<head>
	<title>jplot graphs</title>
	<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.min.css" />
	<script src="jqplot/jquery.min.js" ></script>
	<script src="jqplot/jquery.jqplot.min.js" ></script>
	<script src="jqplot/plugins/jqplot.pieRenderer.min.js"></script>
	<script type="text/javascript" src="jqplot/plugins/jqplot.cursor.min.js"></script>
	<script type="text/javascript" src="jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
	<script src="pie.js" ></script>
	<?php require_once "../common.inc.php"; ?>
	<?php 
	$array = array('memberId'=> 1);
	$expenditure = new Expenditure($array);
	$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));
	print_r($categories);
	?>
</head>

<body onload='drawChart()'>

	<script type="text/javascript">

	var data = [ [ ['Apples', 150], ['Bananas', 50], ['Carrots', <?php echo "40"?>], ] ];
	var data2 = [ [ ['Apples', 150], ['Carrots', <?php echo "40"?>], ] ];
	//note: trailing comma behind doesn't matter

	</script>

	<div id="chartDivId" style="margin-top:20px; margin-left:20px; width:600px; height:300px;"></div>
	<button onclick=drawChart2(data)>Data1</button>
	<button onclick=drawChart2(data2)>Data2</button>

	<script type="text/javascript">
	<?php 
		echo "var data3 = [[";
		foreach ($categories as $category) {
			echo "['" . $category . "', " . $expenditure->getExpenditures_C($category) . "], ";
		} 
		echo "]];";
	?>
		//document.write(data);
		//document.write(data2);
		document.write(data3);
	</script>

	<select name="selectOptions" id="selectOptions">
		<option value=1>Data1</option>
		<option value=2>Data2</option>
		<option value=3>Data3</option>
	</select>
	<button onclick=processSelect(document.getElementById("selectOptions").options[document.getElementById("selectOptions").selectedIndex].value)>Go!</button>
	<br>
	<?php 
	/*	echo "var data3 = [[";
		foreach ($categories as $category) {
			echo "['" . $category . "', " . $expenditure->getExpenditures_C($category) . "], ";
		} 
		echo "]];";*/
	?>
	<select id="selectOptionsAJAX">
		<option value='All'>All</option>
			<?php //UserHome.php?view=overview
			for ($year=2011; $year < 2014; $year++) { 
				for($month=1; $month < 13; $month++) {
					$from = $year . '-' . $month . '-01';
					echo '<option value=' . $from . '>' . getMonth($month) . '/' . $year . '</option>'; 
				}
			} ?>
	</select>
	<button onclick=processSelectAJAX(document.getElementById("selectOptionsAJAX").options[document.getElementById("selectOptionsAJAX").selectedIndex].value)>Go!</button>
	<p>AJAX Response: <div id="txtHint"></div></p>
	<br>

	<div id="chart1" style="height: 300px; width: 500px; position: relative;" class="jqplot-target"></div>
	
</body>
</html>