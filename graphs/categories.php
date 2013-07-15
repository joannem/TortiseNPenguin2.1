<?php require_once "../common.inc.php";
checkLogin();

$id = $_SESSION["member"]->getValue("id");
$array = array('memberId'=> $id);
$expenditure = new Expenditure($array);

$from = isset($_GET["from"]) ? $_GET["from"] : "All";
$to = isset($_GET["to"]) ? $_GET["to"] : date('Y-m-d');

$a_categories = array();
if($from == "All") {
	$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));
	foreach ($categories as $category) {
		$a_categories[0][] = array($category, $expenditure->getExpenditures_C($category));
	}
} else {
	$categories = $expenditure->listCategories_P($expenditure->getValueEncoded("memberId"), $from, $to);
	foreach ($categories as $category) {
		$a_categories[0][] = array($category, $expenditure->getExpenditures_PnC($category, $from, $to));
	}
}

echo json_encode($a_categories);

?>
