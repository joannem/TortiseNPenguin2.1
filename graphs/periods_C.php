<?php 
//require_once("../common.inc.php"); #
//checkLogin();#
function getCatData($categories) {
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	$start = strtotime('2013-01-01');
	$A_day = 24*60*60;
	$today = strtotime(date('Y-m-d'));

	$id = $_SESSION["member"]->getValue("id");
	$array = array('memberId'=> $id);
	$expenditure = new Expenditure($array);
	//$categories = $expenditure->listCategories($id);#
	$ex_DataC = array();
	$idv_DataC = array(); // array for each individual categories
	//print_r($categories);

	for ($i=0; $i<count($categories); $i++) {
		//echo "<br>" . $categories[$i];
		for ($j=$start; $j<$today+$A_day; $j+=$A_day) { 
			$from = date('Y-m-d', $j);
			$to = date('Y-m-d', $j+$A_day);
			$date = date('Y/m/d h:m:s', $j);
			$ex = $expenditure->getExpenditures_PnC($categories[$i], $from, $to);
			$idv_DataC[] = array($date, $ex);
			
		}
		$ex_DataC[] = $idv_DataC;
	}
	//echo "<br>";
	//print_r($ex_DataC);
	echo json_encode($ex_DataC);
}
?>