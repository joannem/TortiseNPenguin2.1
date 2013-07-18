<?php //require_once "../common.inc.php";

function getExData() {
	$start = strtotime('2013-4-01');
	$A_day = 24*60*60;
	$today = strtotime(date('Y-m-d'));

	$id = $_SESSION["member"]->getValue("id");
	$array = array('memberId'=> $id);
	$expenditure = new Expenditure($array);

	$ex_Data = array();

	for ($i=$start; $i < $today+$A_day; $i+=$A_day) { 
			$from = date('Y-m-d', $i);
			$to = date('Y-m-d', $i+$A_day);
			$date = date('Y/m/d h:m:s', $i);
			$ex = $expenditure->getExpenditures_P($from, $to);
			$ex_Data[]	= array($date, $ex-0.0);
		}

	echo json_encode($ex_Data);
}

function getInData() {
	$start = strtotime('2013-4-01');
	$A_day = 24*60*60;
	$today = strtotime(date('Y-m-d'));

	$id = $_SESSION["member"]->getValue("id");
	$array = array('memberId'=> $id);
	$income = new Income($array);
	
	$in_Data = array();
	for ($i=$start; $i < $today+$A_day; $i+=$A_day) { 
			$from = date('Y-m-d', $i);
			$to = date('Y-m-d', $i+$A_day);
			$date = date('Y/m/d h:m:s', $i);
			$in = $income->getTotalIncome($from, $to);
			$in_Data[]	= array($date, $in-0.0);
		}
		
	echo json_encode($in_Data);
}

function getSavData() {
	$start = strtotime('2013-4-01');
	$A_day = 24*60*60;
	$today = strtotime(date('Y-m-d'));

	$id = $_SESSION["member"]->getValue("id");
	$array = array('memberId'=> $id);
	$expenditure = new Expenditure($array);
	$income = new Income($array);
	
	$sav_Data = array();
	for ($i=$start; $i < $today+$A_day; $i+=$A_day) { 
			$from = date('Y-m-d', $i);
			$to = date('Y-m-d', $i+$A_day);
			$date = date('Y/m/d h:m:s', $i);
			$ex = $expenditure->getExpenditures_P($from, $to);
			$in = $income->getTotalIncome($from, $to);
			$sav_Data[] = array($date, $in-$ex);
		}
		
	echo json_encode($sav_Data);
}

?>
