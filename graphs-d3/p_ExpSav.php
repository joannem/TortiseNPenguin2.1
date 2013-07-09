<?php
#FOR LINE GRAPH
require_once("../config.php");
require_once("../common.inc.php");
require_once("../Expenditure.class.php");
require_once("../Income.class.php");

checkLogin();
$id = $_SESSION["member"]->getValue("id");
$array = array('memberId'=> $id);
$income = new Income($array);
$expenditure = new Expenditure($array);

 header("Content-Type: text/tsv");

printf ("date\tExpenditures\tSavings\n");
for ($year=2011; $year < 2014; $year++) { 
	for($month=1; $month < 13; $month++) {
		echo $year . $month;
		$from = $year . '-' . $month . '-01';
		if($month <12 ) {
			$to = date('Y-m-d', strtotime($year . '-' . ($month+1) . '-01')-24*60*60);
		} else {
			$to = ($year) . '-12-31';
		}
						//print_r($expenditure->getValueEncoded("memberId"));
		printf("\t%.2f", $expenditure->getExpenditures_P($from, $to));
		printf("\t%.2f\n", $income->getTotalIncome($from, $to)-$expenditure->getExpenditures_P($from, $to));
	}
} ?>