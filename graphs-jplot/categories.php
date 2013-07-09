<?php require_once "../common.inc.php";
	
$array = array('memberId'=> 1);
$expenditure = new Expenditure($array);
$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));
$from = $_GET["from"];
//echo $from;
//	print_r($categories);

$string = "var thing = [[";
foreach ($categories as $category) {
	$string .= "['" . $category . "', " . $expenditure->getExpenditures_C($category) . "], ";
} 
$string .= "]];";
echo $string;
?>
