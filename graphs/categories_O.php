<?php //require_once "../common.inc.php";

function getPieData() {

	$array = array('memberId'=> 1);
	$expenditure = new Expenditure($array);
	$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));

	$a_categories = array();

	foreach ($categories as $category) {
		$a_categories[0][] = array($category, $expenditure->getExpenditures_C($category));
	}

	echo json_encode($a_categories);
}
?>
