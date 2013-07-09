<?php
#FOR PIE CHART (CSV)
require_once("../common.inc.php");
require_once("../Expenditure.class.php");

checkLogin();
$id = $_SESSION["member"]->getValue("id");
$from = $_GET["from"];
$to = $_GET["to"];

//header("Content-Type: text/csv");

$array = array('memberId'=> $id);
$expenditure = new Expenditure($array);

printf("category,amount\n");

if (isset($_POST["from"]) && $_POST["from"] != "All") {
	$from = $_POST["from"];
	$to = $_POST["to"]; // ADD: if to ="All", assume to is 'today'
	$categories = $expenditure->listCategories_P($expenditure->getValueEncoded("memberId"), $from, $to);
	foreach ($categories as $category) {
		$row = sprintf("%s,%s\n", $category, $expenditure->getExpenditures_PnC($category, $from, $to));
		echo $row;
	}
}
elseif(isset($_POST["from"]) && $_POST["from"] == "All") { 
	$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));
	foreach ($categories as $category) {
		$row = sprintf("%s,%s\n", $category, $expenditure->getExpenditures_C($category));
		echo $row;
		
	}	
} else {

	printf("No Data%s, 1000\n", $_GET["from"]);
}

?>