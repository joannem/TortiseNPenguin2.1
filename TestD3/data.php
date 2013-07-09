<?php
require_once("../config.php");
require_once("../common.inc.php");
require_once("../Expenditure.class.php");
require_once("../Income.class.php");
require_once("../Member.class.php");
?>

<div>
	<table>
		<tr>
			<td>OVERVIEW-EXPENDITURE</td>
			<td>OVERVIEW-INCOME</td>
			<td>OVERVIEW-%EXPENDITURE OF INCOME</td>			
			<td>OVERVIEW-%SAVINGS OF INCOME</td>
		</tr>
		<tr>
			<td>"Month/Year","Total Expenditure"</td>
			<td>"Month/Year","Total Savings"</td>
		</tr>
		<tr>
			<td>
				<?php
				$array = array('memberId'=> 1);
				$income = new Income($array);
				$expenditure = new Expenditure($array);
				for ($year=2011; $year < 2014; $year++) { 
					for($month=1; $month < 13; $month++) {
						echo getMonth($month) . '/' . $year . ',';
						$from = $year . '-' . $month . '-01';
						if($month <12 ) {
							$to = date('Y-m-d', strtotime($year . '-' . ($month+1) . '-01')-24*60*60);
						} else {
							$to = ($year) . '-12-31';
						}
						//print_r($expenditure->getValueEncoded("memberId"));
						printf("$%.2f<br>", $expenditure->getExpenditures_P($from, $to));
					}
				} ?>
			</td>
			<td>
				<?php 
				for ($year=2011; $year < 2014; $year++) { 
					for($month=1; $month < 13; $month++) {
						echo getMonth($month) . '/' . $year . ',';
						$from = $year . '-' . $month . '-01';
						if($month <12 ) {
							$to = date('Y-m-d', strtotime($year . '-' . ($month+1) . '-01')-24*60*60);
						} else {
							$to = ($year) . '-12-31';
						}
						printf("$%.2f<br>", $income->getTotalIncome($from, $to));
					}
				} ?>
			</td>
			<td><?php
				for ($year=2011; $year < 2014; $year++) { 
					for($month=1; $month < 13; $month++) {
						echo getMonth($month) . '/' . $year . ',';
						$from = $year . '-' . $month . '-01';
						if($month <12 ) {
							$to = date('Y-m-d', strtotime($year . '-' . ($month+1) . '-01')-24*60*60);
						} else {
							$to = ($year) . '-12-31';
						}
						//print_r($expenditure->getValueEncoded("memberId"));
						$MExpenditure = $expenditure->getExpenditures_P($from, $to);
						if($MIncome = $income->getTotalIncome($from, $to)) {
							printf("%.2f<br>", $MExpenditure/$MIncome*100);
						}
						else if(!isset($MIncome) && $MExpenditure>0) {
							echo '-infinity<br>';
						}
						else
							echo '0.0<br>';
					}
				} ?>
			</td>
			
			<td>
				<?php 
				for ($year=2011; $year < 2014; $year++) { 
					for($month=1; $month < 13; $month++) {
						echo getMonth($month) . '/' . $year . ',';
						$from = $year . '-' . $month . '-01';
						if($month <12 ) {
							$to = date('Y-m-d', strtotime($year . '-' . ($month+1) . '-01')-24*60*60);
						} else {
							$to = ($year) . '-12-31';
						}
						$MExpenditure = $expenditure->getExpenditures_P($from, $to);
						if($MIncome = $income->getTotalIncome($from, $to)) {
							printf("%.2f<br>", (($MIncome-$MExpenditure)/$MIncome*100));
						}
						else if(!isset($MIncome) && $MExpenditure>0) {
							echo '-infinity<br>';
						}
						else
							echo '0.0<br>';
					}
				} ?>
			</td>

		</tr></table>