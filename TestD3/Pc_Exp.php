<?php
#FOR PIE CHART (CSV)
require_once("../common.inc.php");
require_once("../Expenditure.class.php");

checkLogin();
$id = $_SESSION["member"]->getValue("id");
$from = $_POST["from"];
$to = $_POST["to"];

header("Content-Type: text/csv");

$array = array('memberId'=> $id);
$expenditure = new Expenditure($array);

printf("category,amount\n");
$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"), $from, $to);
if(!isset($categories)) {
	printf("No data, 1000\n");
}
elseif (isset($from) && $from != "All") {
	foreach ($categories as $category) {
		$row = sprintf("%s,%s\n", $category, $expenditure->getExpenditures_PnC($category, $from, $to));
		echo $row;
	}
}
elseif(isset($from) $$ $from == "All") { 
	foreach ($categories as $category) {
		$row = sprintf("%s,%s\n", $category, $expenditure->getExpenditures_C($category));
		echo $row;
		
	}	
} else {
	printf("Error in retrieving data", 1000\n);
}

?>