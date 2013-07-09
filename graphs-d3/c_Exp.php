<?php
#FOR PIE CHART (CSV)
require_once("../common.inc.php");
require_once("../Expenditure.class.php");

checkLogin();
$id = $_SESSION["member"]->getValue("id");

header("Content-Type: text/csv");

$array = array('memberId'=> $id);
$expenditure = new Expenditure($array);

printf("category,amount\n");
$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));
foreach ($categories as $category) {
	$row = sprintf("%s,%s\n", $category, $expenditure->getExpenditures_C($category));
	echo $row;
}
	

?>