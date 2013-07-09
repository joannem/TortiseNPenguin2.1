<?php

require_once "DataObject.class.php";

class Income extends DataObject {

	protected $data = array(
		"memberId" => "",
		"incomeAmt" => "",
		"startDate" => "",
		"endDate" => "",
		"incomeId" => "",
		"type" => "",
		);


public static function getIncomes($startRow, $numRows, $order, $id) { 

	$conn = parent::connect();
	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_INCOME . " WHERE memberId=:id ORDER BY $order LIMIT :startRow, :numRows";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->bindValue(":startRow", $startRow, PDO::PARAM_INT);
		$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
		$st->execute();
		$incomes = array();
		foreach($st->fetchAll() as $row) {
			$incomes[] = new Income($row);
		}
		$st = $conn->query("SELECT found_rows() AS totalRows");
		$row = $st->fetch();
		parent::disconnect($conn);
		return array($incomes, $row["totalRows"]);

	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

#used to compare to total income by averaging income over that period of time
//from and to always starts on the first day of each month, 
//the value of income on the date 'to' will not be included in calculations of ave
public function getTotalIncome($from, $to) {
	$conn = parent::connect();
	$sql = "SELECT SUM(incomeAmt) FROM " . TBL_INCOME . " WHERE memberId = :id AND startDate <= :to AND (endDate >= :from OR endDate = 0)";
	
	try {
		#next time include the :PDO::PARAM_INT stuff in here
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":to", $to, PDO::PARAM_STR);
		$st->bindValue(":from", $from, PDO::PARAM_STR);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		return $row["SUM(incomeAmt)"];

	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

#returns date that income was last edited
#date of '0' means 'yesterday'
public static function getPrev($id) {
	$conn = parent::connect();
	$sql = "SELECT endDate FROM " . TBL_INCOME . " WHERE endDate='0' AND memberId=:id";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		$date = strtotime(date('Y-m-d'));
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	} 
	if ($row) {
		$sql2 = "SELECT max(endDate) FROM " . TBL_INCOME . " WHERE memberId=:id";
		try {
			$st = $conn->prepare($sql2);
			$st->bindValue(":id", $id, PDO::PARAM_INT);
			$st->execute();
			$row = $st->fetch();
			parent::disconnect($conn);
			$date = strtotime($row[0]) + 24*60*60;
		} catch (PDOException $e) {
			parent::disconnect($conn);
			die("Query failed: " . $e->getMessage());
		}
	}
	return $date;
}

#for retrieving individual incomes' records
#FILTER OUT TIMEFRAME AS WELL
public static function getIncome($incomeId) {
	$conn = parent::connect();
	$sql = "SELECT * FROM " . TBL_INCOME . " WHERE incomeId = :incomeId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":incomeId", $incomeId, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		if($row) return new Income($row);
	} catch(PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}


#adds a new income to the table
public function insert() {
	$conn = parent::connect();
	$sql = "INSERT INTO " . TBL_INCOME . " (
		memberId, 		
		incomeAmt,
		startDate,		
		endDate,
		type
		) VALUES (
		:memberId,
		:incomeAmt,
		:startDate,
		:endDate,
		:type
		)";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":incomeAmt", $this->data["incomeAmt"], PDO::PARAM_STR);
		$st->bindValue(":startDate", $this->data["startDate"], PDO::PARAM_STR);
		$st->bindValue(":endDate", $this->data["endDate"], PDO::PARAM_STR);
		$st->bindValue(":type", $this->data["type"], PDO::PARAM_STR);
		$st->execute();
		parent::disconnect($conn);
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function update() {
	$conn = parent::connect(); #not sure about the memberId part
	$sql = "UPDATE " . TBL_INCOME . " SET
		memberId = :memberId, 
		incomeAmt = :incomeAmt,
		startDate = :startDate,
		endDate = :endDate,
		WHERE incomeId = :incomeId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":incomeAmt", $this->data["incomeAmt"], PDO::PARAM_STR);
		$st->bindValue(":startDate", $this->data["startDate"], PDO::PARAM_STR);
		$st->bindValue(":endDate", $this->data["endDate"], PDO::PARAM_STR);
		$st->bindValue(":incomeId", $this->data["incomeId"], PDO::PARAM_INT);
		$st->bindValue(":type", $this->data["type"], PDO::PARAM_STR);
		#print_r($st);
		$st->execute();
		
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function delete() {
	$conn = parent::connect();
	$sql = "DELETE FROM " . TBL_INCOME . " WHERE incomeId = :incomeId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":incomeId", $this->data["incomeId"], PDO::PARAM_INT);
		$st->execute();
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}


}

?>