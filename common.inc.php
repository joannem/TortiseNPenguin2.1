<?php
require_once("config.php");
require_once("Expenditure.class.php");
require_once("Member.class.php");
require_once("Income.class.php");

function displayPageHeader() {
	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>FinanceTracker Home</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

		<!--jqplot-->
		<link rel="stylesheet" type="text/css" href="graphs-jqplot/jqplot/jquery.jqplot.min.css" />
		<script src="graphs/jqplot/jquery.min.js" ></script>
		<script src="graphs/jqplot/jquery.jqplot.min.js" ></script>
		<!--pie-->
		<script src="graphs-jqplot/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
		<!--line-->
		<script type="text/javascript" src="graphs/jqplot/plugins/jqplot.cursor.min.js"></script>
		<script type="text/javascript" src="graphs/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
		<!--bar-->
		<script type="text/javascript" src="graphs/jqplot/plugins/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="graphs/jqplot/plugins/jqplot.pointLabels.min.js"></script>
		<!--js-->
		<script src="graphs/line.js" ></script>
		<script src="graphs/pie.js" ></script>
		<script src="graphs/hori-bar.js"></script>
		<script type="text/javascript" src="forms.js"></script>
	</head>
	<body>
		<!-- Standard Header for Every Page -->
		<div class="row-fluid">
			<div class="span5">
				<a href="UserHome.php">
					<img src="img/Logo.png" class="img-rounded">
				</a>
			</div>
			<div class="span5 alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Notice:</strong> This web page is still under development.
			</div>
			
			<div class="span2 pull-right">
				<a href="logout.php"><h4 class="text-right">Sign Out</h4></a>
			</div>
		</div>
		<br>
		<?php
	}

function displayFormHeader($title) {
	?>

	<!DOCTYPE html>
	<html>
		<head>
			<title><?php echo $title ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!-- Bootstrap -->
			<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
			<style type="text/css">
				label { display: block; float: left; clear: both; text-align: right; margin: 0 0 0 0; width: 40%; }
				/*input, select, textarea { float: right; margin: 1em 0 0 0 ; width: 57%; }
				table, th, tr {border:1px solid black;}*/
				ul, li {display: inline;}
				.error {background: #d33; color: white; padding: 0.2em;}
			</style>
			<script type="text/javascript" src="forms.js"></script>
		</head>
		 <?php 
		 if ($title == "Edit Income") 
		 	echo "<body onload=firstCheck_In()>";
		 elseif($title == "Edit Budget")
		 	echo "<body onload=firstCheck_Bud()>";
		 else
		 	echo "<body>";
		 ?>
			<!-- Standard Header for Every Page -->
			<div class="row-fluid">
				<div class="span4">
					<a href="UserHome.php">
						<img src="img/Logo.png" class="img-rounded">
					</a>
					<p></p> <!--Blank paragraph-->
				</div>
			</div>
			<div class="row-fluid">
				
				<?php
}

//header for those who aren't signed in
function displayLogHeader($title) {
	?>

	<!DOCTYPE html>
	<html>
		<head>
			<title><?php echo $title ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!-- Bootstrap -->
			<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
			<style type="text/css">
				label { display: block; float: left; clear: both; text-align: right; margin: 0 0 0 0; width: 40%; }
				/*input, select, textarea { float: right; margin: 1em 0 0 0 ; width: 57%; }
				table, th, tr {border:1px solid black;}*/
				ul, li {display: inline;}
				.error {background: #d33; color: white; padding: 0.2em;}
			</style>
			<script type="text/javascript" src="forms.js"></script>
		</head>
		<body>
			<!-- Standard Header for Every Page -->
			<div class="row-fluid">
				<div class="span4">
					<a href="index.php">
						<img src="img/Logo.png" class="img-rounded">
					</a>
					<p></p> <!--Blank paragraph-->
				</div>
			</div>
			<div class="row-fluid">
				<div class="offset1 span10">
				<?php
}

function displaySideBar() {
	$id = $_SESSION["member"]->getValueEncoded("id");
	$array = array('memberId'=> $id);
	$expenditure = new Expenditure($array);
	$income = new Income($array);

	$from = date('Y-m') . "-01";
	$nxtMonth = date('m') + 1;
	$to = date('Y') . "-" . $nxtMonth . "-01";

	$MthExpenditure = $expenditure->getExpenditures_P($from, $to);
	$MthIncome = $income->getTotalIncome($from, $to);
	$MthLeft = $MthIncome - $MthExpenditure;
	$MthExpenditure = sprintf("$%.2f", $MthExpenditure);
	$MthIncome = sprintf("$%.2f", $MthIncome);
	$MthLeft = sprintf("$%.2f", $MthLeft);
	
	?>
	<div class="span3"> <!-- Sidebar-->
		<!--Sidebar content-->
		<table class="table table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th><h5><center><?php echo date('Y') ?>, <?php echo strtoupper(date('M')) ?></center></h5></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<b>Statistics for this month... </b><br>
						<dl class="dl-horizontal">
							<dt>Total Income: </dt><dd><?php echo $MthIncome ?></dd>
							<dt>Total Expenditure: </dt><dd><?php echo $MthExpenditure ?></dd>
							<dt>Total Savings: </dt><dd><?php echo $MthLeft ?></dd>
						<dl></dl>

						<hr class="soften">

						<h5>Welcome, <?php print_r($_SESSION["member"]->getValue("username")) ?></h5>
						<p>Click <a href="UserHome.php?view=profile&memberId=<?php echo $id ?>">here</a> to view account details</p>

						<hr class="soften">

						<!-- Links to About, Contact... etc. INSERT LINKS ONCE PAGES ARE DONE-->
						<?php $url = parse_url($_SERVER['REQUEST_URI']); ?>
						<div class="row-fluid">
							<div class="span12">
								<ul class="nav nav-list">
									<li class="nav-header">Miscellaneous Links</li>
									<li <?php if($url["path"] == "/tortiseNpenguin2/UserHome.php") { echo 'class="active"'; } ?>><a href="UserHome.php">Finance Tracker</a></li>
									<li <?php if($url["path"] == "/tortiseNpenguin2/AboutUsPage.php") { echo 'class="active"'; } ?>><a href="AboutUsPage.php">About Us</a></li>
									<li <?php if($url["path"] == "/tortiseNpenguin2/ContactUsPage.php") { echo 'class="active"'; } ?>><a data href="ContactUsPage.php">Contact Us</a></li>
									<li <?php if($url["path"] == "/tortiseNpenguin2/HelpPage.php") { echo 'class="active"'; } ?>><a href="HelpPage.php">Help</a></li>
								</ul>
							</div>
						</div>
					</td>
				</tr>

			</tbody>
		</table>

	</div>
	<?php 
}

function displaySuccess() {
	echo "
		<div class=\"span12 alert\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			<strong>Success:</strong> Your response has been submitted. Click \"edit\" to make changes.
		</div> ";
}

function displayLogSuccess() {
	echo "
		<div class=\"span12 alert\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			<strong>Success:</strong> You are now logged in.
		</div> ";
}

#converts a given integer into Months in readable form
function getMonth($value) {
	switch ($value) {
		case '1':
			return "Jan";
			break;
		case '2':
			return "Feb";
			break;
		case '3':
			return "Mar";
			break;	
		case '4':
			return "Apr";
			break;
		case '5':
			return "May";
			break;
		case '6':
			return "Jun";
			break;
		case '7':
			return "Jul";
			break;
		case '8':
			return "Aug";
			break;
		case '9':
			return "Sep";
			break;	
		case '10':
			return "Oct";
			break;
		case '11':
			return "Nov";
			break;
		case '12':
			return "Dec";
			break;	
		default:
			return "MthError";
			break;
	}
}

#creates a string for date to match MySQL's format
#automatically sets day as '01'
function createDate($month, $year) {
	return $year . "-" . $month . "-01";
}

function validateField($fieldName, $missingFields) {
	if(in_array($fieldName, $missingFields)) {
		echo ' error';
	}
}

function setChecked(DataObject $obj, $fieldName, $fieldValue) {
	if($obj->getValue($fieldName) == $fieldValue) {
		echo ' checked="checked"';
	}
}

function setArrChecked($array, $fieldName, $fieldValue) {
	if( (isset($array[$fieldName])) && ($array[$fieldName] == $fieldValue) ) {
		echo ' checked="checked"';
	}
}

function setSelected(DataObject $obj, $fieldName, $fieldValue) {
	if($obj->getValue($fieldName) == $fieldValue) {
		echo ' selected="selected"';
	}
}

function setArrSelected($array, $fieldName, $fieldValue) {
	if( (isset($array[$fieldName])) && ($array[$fieldName] == $fieldValue) ) {
		echo ' selected="selected"';
	}
}

#calculates number of days between two dates
function dayDiff($from, $to) {
	$to = strtotime($to); // or your date as well
	$from = strtotime($from);
	$datediff = $to - $from;
	return floor($datediff/(60*60*24));
}

function checkLogin() {
	session_start();
	if(!$_SESSION["member"] || !$_SESSION["member"] = Member::getMember($_SESSION["member"]->getValue("id"))) {
		$_SESSION["member"] = "";
		header("Location: login.php");
		exit;
	} 
}

function displayPageFooter() { ?>
	<br>
	<br>
	<br>
	<div class="span12">
	<p><?php #for checking :D
		#$url = parse_url($_SERVER['REQUEST_URI']);
		#echo $url["path"];
	?></p>
	<p style="color: blue;">Here's a dummy footer: <br>
		"Portions of this code from Beginning PHP 5.3, ISBN: 978-0-470-41396-8, copyright John Wiley & Sons, Inc.: 2000-2013, by Matt Doyle, published under the Wrox imprint are used by permission of John Wiley & Sons, Inc All rights reserved. This book and the Wrox code are available for purchase or download at www.wrox.com" <br>
	</p>
	<p style="color: blue;">
		<i>Yes, we also used bootstrap for css hah.</i>
	</p>
	<p style="color: grey;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
	<!--<script src="http://code.jquery.com/jquery.min.js"></script>-->
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>
<?php
}	?>